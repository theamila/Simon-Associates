<?php

namespace App\Http\Controllers;

use App\Mail\approverMail;
use App\Models\CompanyDetails;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\handler;
use App\Models\payment;
use App\Models\User;
use App\Models\Modelreceipt;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
class NavisionController extends Controller
{

    public function allInvoice()
    {
        $data = Invoice::orderBy('id', 'desc')->get();

        return view('User1.allInvoice', compact('data'));
    }

    public function twoallInvoice()
    {
        $data = Invoice::orderBy('id', 'desc')->paginate(100);

        return view('User2.allInvoice', compact('data'));
    }

    public function treeAllInvoices()
    {
        $data = Invoice::orderBy('id', 'desc')->paginate(100);

        return view('User3.allInvoice', compact('data'));
    }

    public function RejectInvoice()
    {
        $data = Invoice::where('status', 9)->orderBy('id', 'desc')->paginate(100);

        return view('User1.rejected', compact('data'));
    }

    public function RejectInvoiceView($id)
    {
        $Invoicedata = Invoice::findOrFail($id);
        if ($Invoicedata) {

            $data = InvoiceDetails::where('invoiceNumber', $Invoicedata->invoiceNumber)->get();

            return view('User2.rejectedView', compact('data'));
        } else {
            return back();
        }
    }



    public function dashboard()
    {
        $data = Invoice::orderByDesc('id')->paginate(10);

        $sa = [2, 3, 4, 5];
        $apr_cnt = Invoice::where('status', 6)->count();
        $out_cnt = Invoice::where('status', 7)->count();
        $ong_cnt = Invoice::whereIN('status', $sa)->count();

        $recent = Invoice::where('status', 1)->get();
        return view('User1.home', compact('data', 'apr_cnt', 'out_cnt', 'ong_cnt', 'apr_cnt', 'recent'));
    }

    public function CompanyRegister()
    {
        $handlers = handler::all();

        return view('User1.Registration', compact('handlers'));
    }

    public function ongoingInvoice()
    {
        $data = Invoice::where('status', '2')->orWhere('status', '3')->orWhere('status', '4')->orWhere('status', '5')->orWhere('status', '6')->get();

        return view('User1.ongoing', compact('data'));
    }

    public function ApprovedInvoice()
    {
        $data = Invoice::where('status', '6')->get();

        return view('User1.Approved', compact('data'));
    }

    public function OutstandingInvoice()
    {
        $data = Invoice::where('status', '7')->get();

        foreach ($data as $get) {
            $count = DB::table('invoice_details')
                ->where('invoiceNumber', $get->invoiceNumber)
                ->where('status', 0)
                ->get();

            if (count($count) == 0) {
                $get->status = 8;
                $get->save();
            }
        }

        $data = Invoice::where('status', '7')->get();

        $company = CompanyDetails::all();

        return view('User1.Outstanding', compact('data', 'company'));
    }
    public function Receipt()
    {

        $data = Modelreceipt::orderByDesc('id')->get();
        $ComData = Invoice::all();

        return view('User1.Receipt', compact('data', 'ComData'));
    }

    public function dashboardUserTwo()
    {
        $apr_cnt = Invoice::where('status', 7)->count();
        return view('User2.Home', compact('apr_cnt'));
    }

    public function modify($invoiceNumber)
    {

        $invoiceNumber = str_replace('-', '/', $invoiceNumber);
        $invoice = Invoice::where('invoiceNumber', $invoiceNumber)->first();
        $invoice_data = InvoiceDetails::where('invoiceNumber', $invoiceNumber)->get();

        $bank = payment::all();

        return view('User1.editInvoicer', compact('invoice', 'invoice_data', 'invoiceNumber', 'bank'));
    }

    public function updateForm()
    {
        $data = payment::all();
        $userData = User::all();
        $handlerData = handler::all();
        $customersList = CompanyDetails::all();


        return view('User2.update-form', compact('data', 'userData', 'handlerData', 'customersList'));
    }

    // ===========================================================

    public function user2()
    {
        $data = Invoice::orderByDesc('id')->paginate(10);

        $sa = [2, 3, 4, 5];
        $apr_cnt = Invoice::where('status', 6)->count();
        $out_cnt = Invoice::where('status', 7)->count();
        $ong_cnt = Invoice::whereIN('status', $sa)->count();

        $invoices = Invoice::latest()->take(10)->get();

        $amount = [];

        foreach ($invoices as $invoice) {
            $total = 0; // Reset total for each invoice
            $subInvoice = InvoiceDetails::where('invoiceNumber', $invoice->invoiceNumber)->get();

            foreach ($subInvoice as $detail) {
                $total = 0; // Initialize total outside the loop
                foreach ($subInvoice as $detail) {
                    if ($detail->discount != 0) {
                        $totalT = $detail->price * $detail->dollerRate;
                        $totalT -= ($totalT * $detail->discount) / 100;
                        // $totalT = $totalT/$detail->discount;
                    } else {
                        $totalT = $detail->price * $detail->dollerRate;
                    }
                    if ($detail->convertToD == 1) {
                        $totalT = $detail->price * $detail->dollerRate;
                    }
                    $total += $totalT;

                    // $total += $detail->price * $detail->dollerRate - ($detail->discount != 0 ? $total / $detail->discount : 0);
                }
            }

            $amount[$invoice->id] = $total;
        }
        $amount = array_reverse($amount, true);

        return view('User2.home', compact('data', 'apr_cnt', 'out_cnt', 'ong_cnt', 'apr_cnt', 'invoices', 'amount'));
    }

    public function viewUserTwo($invoiceNumber)
    {
        $invoiceNumberModify = str_replace('-', '/', $invoiceNumber);
        $invoice_data = InvoiceDetails::where('invoiceNumber', $invoiceNumberModify)->get();
        $invoice = Invoice::where('invoiceNumber', $invoiceNumberModify)->first();

        $bankAccount = payment::where('id', $invoice->bankId)->first();

        return view('User2.generateInvoice', compact('invoice_data', 'invoiceNumber', 'invoice', 'bankAccount'));
    }

    public function sendUsertree($invoiceNumber, $notify)
    {
        $invoiceNumberModify = str_replace('-', '/', $invoiceNumber);
        $data = Invoice::where('invoiceNumber', $invoiceNumberModify)->first();
        $data->status = '3';
        $data->save();

        if ($notify == "true") {
            $mailTo = User::where('role', 3)->orderBy('id', 'desc')->first();

            $mailDetails = [];

            if ($mailTo) {
                Mail::to($mailTo)->send(new approverMail($mailDetails));
            }
        }

        return redirect()->route('new-invoice-user')->with('good', 'Invoice successfully sent to the approver.');
    }

    public function sendUserOne($invoiceNumber)
    {
        $invoiceNumberModify = str_replace('-', '/', $invoiceNumber);
        $data = Invoice::where('invoiceNumber', $invoiceNumberModify)->first();
        $data->status = '5';
        $data->save();

        return redirect()->route('new-invoice-user')->with('good', 'Invoice successfully sent to the approver.');
    }

    // ===========================================================

    public function generateInvoice($id, Request $request)
    {

        $request->validate([
            'invoiceNumber' => 'required|unique:invoices,invoiceNumber',
        ]);

        try {
            $data = CompanyDetails::findOrFail($id);
            $handler = handler::where('id', $data->handleBy)->first();

            $invoice = new Invoice();

            $invoice->to = $data->to;
            $invoice->email = $data->email;
            $invoice->companyName = $data->companyName;
            $invoice->address = $data->address;
            $invoice->status = '1';
            $invoice->handleBy = $handler->id;
            $invoice->refID = $data->id;
            $invoice->customerRefId = $data->id;
            $invoice->date = Carbon::now('Asia/Colombo')->format('Y-m-d');

            $invoiceNumber = $request->query('invoiceNumber');

            $invoiceNumber = str_replace('-', '/', $invoiceNumber);

            $invoice->invoiceNumber = $invoiceNumber;

            $invoice->save();

            $invoiceNumber = str_replace('/', '-', $invoiceNumber);

            return redirect()->route('invoiceGenForm', ['invoiceNumber' => $invoiceNumber]);
        } catch (Exception $e) {

            return back()->with('error', 'Something Wrong. : ' . $e->getMessage());
        }
    }
}

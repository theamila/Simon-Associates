<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyDetails;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\handler;
use App\Models\payment;
use App\Models\User;
use App\Models\Modelreceipt;
// use Illuminate\Console\View\Components\Alert;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Alert;

class userTwoController extends Controller
{
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

        return view('User2.receipt');
    }

    public function OutstandingInvoiceView()
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

        return view('User2.Outstanding', compact('data', 'company'));
    }

    public function Reports()
    {
        $data = Invoice::where('status', 7)->get();
        $sdata = handler::all();
        $serviceBy = 0;
        $sdate = null;
        $edate = null;

        $amount = [];

        $cdata = Invoice::latest()->take(30)->get();

        foreach ($cdata as $invoice) {
            $total = 0;
            $subInvoice = InvoiceDetails::where('invoiceNumber', $invoice->invoiceNumber)->get();

            foreach ($subInvoice as $detail) {
                $totalT = $detail->price * $detail->dollerRate; // Calculate total price without discount

                if ($detail->mark_status == 0 && $detail->discount != 0) {
                    $discountAmount = ($totalT * $detail->discount) / 100; // Calculate discount amount
                    $totalT -= $discountAmount; // Apply discount
                }
                $total += $totalT;
            }

            $amount[$invoice->id] = $total;
        }

        $cudata = CompanyDetails::all();

        $table2 = $cudata;
        // $table2 = CompanyDetails::all();

        $customerID = 0;

        return view('user2.Reports', compact('data', 'sdata', 'serviceBy', 'sdate', 'edate', 'amount', 'cdata', 'cudata', 'customerID', 'table2'));
    }

    public function filterInvoices(Request $request)
    {
        $sdate = $request->input('sdate');
        $edate = $request->input('fdate');
        $serviceBy = $request->input('serviceBy');
        $customerID = $request->input('customer');

        $table2 = CompanyDetails::all();

        $sdata = handler::all();
        $cudata = CompanyDetails::all();

        $cdata = Invoice::latest()->take(30)->get();

        $amount = [];

        foreach ($cdata as $invoice) {
            $total = 0; // Reset total for each invoice
            $subInvoice = InvoiceDetails::where('invoiceNumber', $invoice->invoiceNumber)->get();

            foreach ($subInvoice as $detail) {
                $total += $detail->price * $detail->dollerRate;
            }

            $amount[$invoice->id] = $total;
        }

        if (!$sdate || !$edate) {

            $data = Invoice::all();

            if ($serviceBy == 0) {
                if ($customerID == 0) {
                    $data = Invoice::all();

                    $cdata = Invoice::latest()->take(30)->get();

                    $table2 = CompanyDetails::all();
                } else {
                    $data = Invoice::where('refID', $customerID)->get();

                    $cdata = Invoice::where('refID', $customerID)->latest()->take(30)->get();

                    $table2 = CompanyDetails::where('id', $customerID)->get();
                }
            } else {
                if ($customerID != 0) {
                    $data = Invoice::where('refID', $customerID)->where('handleBy', $serviceBy)->get();

                    $cdata = Invoice::where('refID', $customerID)->where('handleBy', $serviceBy)->latest()->take(30)->get();
                } else {
                    $data = Invoice::where('handleBy', $serviceBy)->get();

                    $cdata = Invoice::where('handleBy', $serviceBy)->latest()->take(30)->get();

                    $table2 = CompanyDetails::where('handleBy', $serviceBy)->get();
                }
            }

            // ==================================================================================
            // $invoices = Invoice::latest()->take(10)->get();

            $amount = [];

            foreach ($cdata as $invoice) {
                $total = 0; // Reset total for each invoice
                $subInvoice = InvoiceDetails::where('invoiceNumber', $invoice->invoiceNumber)->get();

                foreach ($subInvoice as $detail) {
                    $total += $detail->price * $detail->dollerRate;
                }

                $amount[$invoice->id] = $total;
            }

            return view('user2.Reports', compact('data', 'sdata', 'serviceBy', 'sdate', 'edate', 'amount', 'cdata', 'cudata', 'customerID', 'table2'));
        }

        if ($sdate >= $edate) {
            // Handle validation error
            toast('Start date must be before the end date.', 'error');
            $data = Invoice::all();

            return view('user2.Reports', compact('data', 'sdata', 'serviceBy', 'sdate', 'edate', 'amount', 'cdata', 'cudata', 'customerID'));
        }

        // Retrieve invoices based on the date range

        $sdate = $request->input('sdate') ? Carbon::parse($request->input('sdate'))->format('Y-m-d') : null;
        $edate = $request->input('fdate') ? Carbon::parse($request->input('fdate'))->format('Y-m-d') : null;

        if ($serviceBy == 0) {
            if ($customerID == 0) {
                $data = Invoice::whereBetween('created_at', [$sdate, $edate])->get();

                $cdata = Invoice::whereBetween('created_at', [$sdate, $edate])
                    ->latest()
                    ->take(30)
                    ->get();
            } else {
                $data = Invoice::whereBetween('created_at', [$sdate, $edate])
                    ->where('refID', $customerID)
                    ->get();

                $cdata = Invoice::whereBetween('created_at', [$sdate, $edate])
                    ->where('refID', $customerID)
                    ->latest()
                    ->take(30)
                    ->get();
            }
        } else {
            if ($customerID != 0) {
                $data = Invoice::whereBetween('created_at', [$sdate, $edate])
                    ->where('refID', $customerID)
                    ->where('handleBy', $serviceBy)
                    ->get();

                $cdata = Invoice::whereBetween('created_at', [$sdate, $edate])
                    ->where('refID', $customerID)
                    ->where('handleBy', $serviceBy)
                    ->latest()
                    ->take(30)
                    ->get();
            } else {
                $data = Invoice::whereBetween('created_at', [$sdate, $edate])
                    ->where('handleBy', $serviceBy)
                    ->get();

                $cdata = Invoice::whereBetween('created_at', [$sdate, $edate])
                    ->where('handleBy', $serviceBy)
                    ->latest()
                    ->take(30)
                    ->get();
            }
        }

        // ==================================================================================
        // $invoices = Invoice::latest()->take(10)->get();

        $amount = [];

        foreach ($cdata as $invoice) {
            $total = 0; // Reset total for each invoice
            $subInvoice = InvoiceDetails::where('invoiceNumber', $invoice->invoiceNumber)->get();

            foreach ($subInvoice as $detail) {
                $total += $detail->price * $detail->dollerRate;
            }

            $amount[$invoice->id] = $total;
        }



        // Return the filtered invoices
        return view('user2.Reports', compact('data', 'sdata', 'serviceBy', 'sdate', 'edate', 'amount', 'cdata', 'cudata', 'customerID'));
    }

    public function reporttwo()
    {
        // $data = Invoice::whereNotIn('status', [1,9])->orderBy('id', 'desc')->paginate(15);
        return view('User2.reportTwo');
    }

    public function reporttwoView($id, $crn)
    {

        $company = CompanyDetails::find($id);

        if ($company) {
            $data = Invoice::where('customerRefId', $company->id)
            ->where('currency', $crn)->get();

            if (count($data) > 0) {

                return view('reports.hostory', compact('data'));
            } else {
                Alert::error('Error', 'Data not Found..');
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }

    public function fixReceipt()
    {
        $data = Modelreceipt::where('payedAmount', null)->orWhere('payedAmount', 0.00)->get();
        return view('user2.fixReceipt', compact('data'));
    }

    public function receiptUpdatesave(Request $request, $id)
    {
        $request->validate([
            'receipt_price' => 'required',
        ]);

        $receipt = Modelreceipt::find($id);

        if (!$receipt) {
            return redirect()->back()->with('error', 'Receipt not found.');
        }

        $receipt->payedAmount = $request->input('receipt_price');

        return $receipt->save()
            ? redirect()->back()->with('success', 'Update successful.')
            : redirect()->back()->with('error', 'Failed to update receipt. Please try again.');
    }


    public function agingReport()
    {

        return view('function.aging');
    }

    public function agingReport3()
    {
        return view('function.aging3');
    }

  public function agingReportuser()
    {
        return view('function.aging1');
    }

    public function userOneDeleteOngoingInvoice($invoiceNumber)
{
    // Correctly replace '-' with '/'
    $invoiceNumber = str_replace('-', '/', $invoiceNumber);

    // Start the transaction
    DB::beginTransaction();

    try {
        // Find and delete the invoice
        $data = Invoice::where('invoiceNumber', $invoiceNumber)->first();
        if ($data) {
            $data->delete();
        }

        // Delete related invoice details
        $invoiceDetails = InvoiceDetails::where('invoiceNumber', $invoiceNumber)->get();
        if ($invoiceDetails->isNotEmpty()) {
            foreach ($invoiceDetails as $item) {
                $item->delete();
            }
        }

        // Commit the transaction
        DB::commit();

        // Success message and redirect
        Alert::success('Success', 'Invoice Deleted Successfully.');
        return redirect()->back();

    } catch (\Exception $e) {
        // Rollback the transaction if there was an error
        DB::rollBack();
        Alert::error('Error', 'An error occurred. Please try again.');
        return redirect()->back();
    }
}
}

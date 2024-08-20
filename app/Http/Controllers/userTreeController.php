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
use Illuminate\Support\Facades\DB;

class userTreeController extends Controller
{

    public function rejectInvoiceUser()
    {
        $data = Invoice::where('status', 9)->orderBy('id', 'desc')->paginate(100);

        return view('User3.rejected', compact('data'));
    }

    public function RejectInvoiceView($id)
    {
        $Invoicedata = Invoice::findOrFail($id);
        if ($Invoicedata) {

            $data = InvoiceDetails::where('invoiceNumber', $Invoicedata->invoiceNumber)->get();

            return view('User3.rejectedView', compact('data'));

        } else {
            return back();
        }

    }


    public function OutstandingInvoice()
    {
        $data = Invoice::where('status', '7')->get();

        foreach($data as $get)
        {
            $count = DB::table('invoice_details')
            ->where('invoiceNumber', $get->invoiceNumber)
            ->where('status', 0)
            ->get();

        if (count($count) == 0) {
            $get->status = 8;
            $get->save();
        }
        }

        $InvoiceData = [];
        $data = Modelreceipt::orderByDesc('id')->paginate(30);

        foreach ($data as $get) {
            $invoiceDetails = Invoice::where('invoiceNumber', $get->invoiceNumber)->first();
            $InvoiceData[$get->invoiceNumber] = $invoiceDetails;
        }

        // $InvoiceData = Invoice::where('status', '7')->get();

        return view('User3.receipt', compact('data', 'InvoiceData'));
    }

    public function OutstandingInvoiceView()
    {
        $data = Invoice::where('status', '7')->get();

        foreach($data as $get)
        {
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

        return view('User3.Outstanding', compact('data'));
    }

    // public function ongoingInvoiceTwo()
    // {
    //     $data = Invoice::where('status', '2')
    //     ->orWhere('status', '3')
    //     ->orWhere('status', '4')
    //     ->orWhere('status', '5')
    //     ->get();

    // return view('User3.ongoing', compact('data'));
    // }
}

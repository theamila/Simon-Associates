<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyDetails;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\Payment;

class Madem3 extends Controller
{
    public function home()
    {
        $data = Invoice::orderByDesc('id')->paginate(10);

        $sa = [2,3,4,5];
        $apr_cnt = Invoice::where('status', 6)->count();
        $out_cnt = Invoice::where('status', 7)->count();
        $ong_cnt = Invoice::whereIN('status', $sa)->count();

        return view('User3.Home', compact('data', 'apr_cnt', 'out_cnt','ong_cnt','apr_cnt'));
    }

    public function newInvoices()
    {
        $data = Invoice::where('status', '3')->get();
        return view('User3.newInvoice', compact('data'));
    }
    public function viewUser3($invoiceNumber)
    {
        $invoiceNumberModify = str_replace('-', '/', $invoiceNumber);
        $invoice_data = InvoiceDetails::where('invoiceNumber', $invoiceNumberModify)->get();

        $invoice = Invoice::where('invoiceNumber', $invoiceNumberModify)->first();

        $bankAccount = payment::where('id', $invoice->bankId)->first();

        return view('User3.generateInvoice', compact('invoice_data', 'invoiceNumber', 'bankAccount'));
    }

    public function sentBack($invoiceNumber)
    {
        $invoiceNumber = str_replace('-', '/', $invoiceNumber);
        $data = Invoice::where('invoiceNumber', $invoiceNumber)->first();

        if ($data) {
            $data->status = "4";
            $data->save();

            return redirect()->route('new-invoice-user-tree')->with('good', 'Invoice successfully sent back.');
        } else {
            return back()->with('bad', 'Invoice not found.');
        }
    }

}

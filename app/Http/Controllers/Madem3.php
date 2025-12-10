<?php

namespace App\Http\Controllers;

use App\Models\advancePayment;
use Illuminate\Http\Request;
use App\Models\CompanyDetails;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\Payment;

class Madem3 extends Controller
{
    public function home()
    {
        $data = Invoice::orderByDesc('id')->paginate(100);

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

        $bank = payment::where('id', $invoice->bankId)->first();

        $company_data = Invoice::where('invoiceNumber', $invoiceNumberModify)->firstOrFail();
        $advancePayments = advancePayment::where('customer_id', $company_data->customerRefId)->where('is_applied', 0)->get();

        return view('User3.generateInvoice', compact('invoice_data', 'invoiceNumber', 'bank', 'company_data', 'advancePayments'));
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

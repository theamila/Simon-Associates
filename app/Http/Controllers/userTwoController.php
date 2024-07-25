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
use Illuminate\Support\Carbon;

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

        // Create InvoiceData array
        $InvoiceData = [];
        $invoices = Modelreceipt::orderByDesc('id')->paginate(50);

        foreach ($invoices as $get) {
            $invoiceDetails = Invoice::where('invoiceNumber', $get->invoiceNumber)->first();
            if ($invoiceDetails) {
                $InvoiceData[$get->invoiceNumber] = $invoiceDetails;
            }
        }

        return view('User2.receipt', compact('invoices', 'InvoiceData'));





        // $data = Invoice::where('status', '7')->get();

        // foreach ($data as $get) {
        //     $count = DB::table('invoice_details')
        //         ->where('invoiceNumber', $get->invoiceNumber)
        //         ->where('status', 0)
        //         ->get();

        //     if (count($count) == 0) {
        //         $get->status = 8;
        //         $get->save();
        //     }
        // }

        // $data = Invoice::where('status', '7')->get();

        // $company = CompanyDetails::all();

        // return view('User1.Outstanding', compact('data', 'company'));



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

        return view('User2.Outstanding', compact('data'));
    }

    // public function ongoingInvoiceTwo()
    // {
    //     $data = Invoice::where('status', '2')
    //     ->orWhere('status', '3')
    //     ->orWhere('status', '4')
    //     ->orWhere('status', '5')
    //     ->get();

    // return view('User2.ongoing', compact('data'));
    // }

    public function Reports()
    {
        $data = Invoice::all();
        $sdata = handler::all();
        $serviceBy = 0;
        $sdate = null;
        $edate = null;

        $amount = [];

        $cdata = Invoice::latest()->take(30)->get();

        foreach ($cdata as $invoice) {
            $total = 0; // Reset total for each invoice
            $subInvoice = InvoiceDetails::where('invoiceNumber', $invoice->invoiceNumber)->get();

            foreach ($subInvoice as $detail) {
                $totalT = $detail->price * $detail->dollerRate; // Calculate total price without discount

                if ($detail->mark_status == 0 && $detail->discount != 0) {
                    $discountAmount = ($totalT * $detail->discount) / 100; // Calculate discount amount
                    $totalT -= $discountAmount; // Apply discount
                }

                $total += $totalT; // Accumulate total price
            }

            $amount[$invoice->id] = $total;
        }

        $cudata = CompanyDetails::all();

        $table2 = CompanyDetails::all();

        $customerID = 0;

        return view('user2.Reports', compact('data', 'sdata', 'serviceBy', 'sdate', 'edate', 'amount', 'cdata', 'cudata', 'customerID', 'table2'));
    }

    public function filterInvoices(Request $request)
    {
        // Retrieve start date and end date from the request
        $sdate = $request->input('sdate');
        $edate = $request->input('fdate');
        $serviceBy = $request->input('serviceBy');
        // $customer = $request->input('customer');
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
        // ========================================================================================

        // Return the filtered invoices
        return view('user2.Reports', compact('data', 'sdata', 'serviceBy', 'sdate', 'edate', 'amount', 'cdata', 'cudata', 'customerID'));
    }
}

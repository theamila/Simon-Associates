<?php

namespace App\Http\Controllers;

use App\Models\advancePayment;
use App\Models\CompanyDetails;
use Illuminate\Http\Request;
use Alert;

class utilitController extends Controller
{
    public function advancePayment(Request $request, advancePayment $advance){
        $Invoice = CompanyDetails::find($request->customer_id);

        $advance->customer_id = $request->customer_id;
        $advance->currency = $request->currency;
        $advance->payment_date = $request->date;
        $advance->invoiceId = $request->invoiceNo;
        $advance->receiptNo = $request->receiptNo;
        $advance->amount = $request->amount;
        $advance->description = $request->description;
        $advance->payment_method = $request->payment_method;

        $advance->save();

        $get = $advance;

        $back = true;

        return view('Invoice.advance', compact('Invoice', 'get', 'back'));
    }

    public function previewAdvance($id){

        $back = false;
        $get = advancePayment::find($id);
        $Invoice = CompanyDetails::find($get->customer_id);

        return view('Invoice.advance', compact('Invoice', 'get', 'back'));
    }

    public function  deleteAdvance($id) {
        advancePayment::find($id)->delete();

         Alert::success('Success', 'Deleted Successfully.');

        return redirect()->back();
    }
}

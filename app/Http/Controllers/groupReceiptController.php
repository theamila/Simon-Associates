<?php

namespace App\Http\Controllers;

use App\Models\CompanyDetails;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\Modelreceipt;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Alert;

class groupReceiptController extends Controller
{
    public function groupReceipt()
    {

        $data = Invoice::where('status', "7")->get();

        if ($data->isEmpty()) {
            Alert::error('Error.', 'No Outstanding Invoices.');

            return redirect()->back();
        }

        return view('Invoice.groupReceipt', compact('data'));
    }

    public function sendCheckedReceipts(Request $request)
    {
        $selectedReceipts = $request->input('receipt_ids', []);

        if (!empty($selectedReceipts)) {

            session()->put('selectedReceipts', $selectedReceipts);
            session()->put('invoiceArray', $selectedReceipts);

            return view('groupReceipt.outstanding');
        }
        return redirect()->back()->with('error', 'Invoices not selected.!');
    }



    public function settleoutstandinggroup(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'receipt' => 'required|string',
            'invoiceID' => 'required|exists:invoices,id',
        ], [
            'amount.required' => 'The amount field is required.',
            'amount.numeric' => 'The amount must be a number.',
            'amount.min' => 'The amount must be at least 0.01.',
            'receipt.required' => 'The receipt number is required.',
            'invoiceID.required' => 'The invoice ID is required.',
            'invoiceID.exists' => 'The selected invoice does not exist.',
        ]);


        $invoiceId = $request->input('invoiceID');
        $amount = $request->input('amount');

        $invoiceData = Invoice::find($invoiceId);
        if ($invoiceData) {
            $customer = CompanyDetails::find($invoiceData->customerRefId);
            if ($customer) {

                $customer->outstanding = $customer->outstanding - $amount;
                $customer->save();

                $sessionData = session('selectedReceipts');

                $sessionData = array_filter($sessionData, function ($id) use ($invoiceId) {
                    return $id !== $invoiceId;
                });

                $receipt = new Modelreceipt;

                $receipt->invoiceNumber = $invoiceData->invoiceNumber;
                $receipt->receiptNumber = $request->receipt;
                $receipt->additional = '0';
                $receipt->payedDate = Carbon::now('Asia/Colombo');
                $receipt->offline = 0;
                $receipt->save();



                $invoiceDetails = InvoiceDetails::where('invoiceNumber', $invoiceData->invoiceNumber)->get();
                // dd($invoiceDetails);
                $totalAmount = 0.00;
                foreach ($invoiceDetails as $item) {
                    $totalAmount += $item->price;
                }
                // dd($totalAmount);

                if ($amount >= $totalAmount) {
                    $invoiceData->status = 8;
                    $invoiceData->save();
                }





                session()->put('receiptNumber', $request->receipt);

                session(['selectedReceipts' => array_values($sessionData)]);

                if (!session()->has('selectedReceipts') || empty(session('selectedReceipts'))) {

                    // $this->groupreceiptgenerate($customer);

                    return redirect('/group/receipt/generate/' . $customer->id);
                }

                return view('groupReceipt.outstanding')->with('success', 'Invoice settled successfully.');
            } else {
                return redirect()->back()->with('error', 'Customer Not Found..');
            }
        } else {
            return redirect()->back()->with('error', 'Invoice Not Found..');
        }
    }

    public function groupreceiptgenerate($id)
    {
        $invoiceData = session('invoiceArray');


        $customer = CompanyDetails::find($id);
        if ($customer) {
            return view('invoice.groupReceipttemplate', [
                'isSubmit' => true,
                'Invoice' => $customer,
                'data' => $invoiceData
            ]);
        } else {
            return redirect()->back()->with('Customer Not Found.');
        }
    }

    public function groupsessionforgot()
    {
        session()->forget('invoiceArray');
        session()->forget('receiptNumber');

        return redirect('2/outstanding/view');
    }

    public function settleInvoice($id)
    {
        $data = Invoice::find($id);
        if ($data) {
            $data->status = "8";
            $data->save();

            Alert::success('Done', 'Invoice Settled Success.');
            return redirect()->back();
        } else {
            Alert::error('Error', 'Invoice Not Found..');
            return redirect()->back();
        }
    }

    // public function reset()
    // {
    //     $invoices = Invoice::all();

    //     foreach ($invoices as $item) {
    //         $customer = CompanyDetails::where('address', $item->address)->first();

    //         if ($customer) {
    //             $item->customerRefId = $customer->id;
    //             $item->save();
    //         } else {
    //             \Log::warning("Customer not found for invoice with address: {$item->address}");
    //         }
    //     }

    //     return redirect()->back()->with('status', 'Invoices updated successfully!');
    // }

    public function fixOutstanding(){

        $customers = CompanyDetails::where('state', 1)->get();
        return view('fix', compact('customers'));
    }


    public function updateOutstanding(Request $request, $id)
    {
        $customer = CompanyDetails::findOrFail($id);
        $customer->outstanding = $request->input('outstanding_price');
        $customer->save();

        return redirect()->back()->with('success', 'Outstanding price updated successfully');
    }

    public function deactivate($id)
{
    $customer = CompanyDetails::findOrFail($id);
    $customer->state = 0; // Assuming you have an 'active' column for deactivation
    $customer->save();

    return redirect()->back()->with('success', 'Customer deactivated successfully');
}

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\handler;
use Alert;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\Modelreceipt;
use Exception;

class PaymentController extends Controller
{
    public function updateData(Request $request)
    { {
            // Validate the incoming request
            $request->validate([
                'acName' => 'required|string',
                'accountNo' => 'required|string',
                'bankName' => 'required|string',
                'bankAddress' => 'required|string',
                'swiftCode' => 'required|string',
                'id' => 'required',
            ]);

            $id = $request->input('id');

            $formData = $request->only([
                'acName',
                'accountNo',
                'bankName',
                'bankAddress',
                'swiftCode',
            ]);

            Payment::where('id', $id)
                ->update($formData);

            toast('Bank Details Update Successfully', 'success');
            //    Alert::success('Success', 'Bank Details Update Successfully');

            return redirect()->back();
        }
    }

    public function addBank(Request $request)
    {
        $request->validate([
            'acName' => 'required|string',
            'accountNo' => 'required|string',
            'bankName' => 'required|string',
            'bankAddress' => 'required|string',
            'swiftCode' => 'required|string',
        ]);

        Payment::create([
            'acName' => $request->acName,
            'accountNo' => $request->accountNo,
            'bankName' => $request->bankName,
            'bankAddress' => $request->bankAddress,
            'swiftCode' => $request->swiftCode,
            'default' => 0,
        ]);

        Alert::success('Success', 'Bank Details added Successfully');

        return redirect()->back();
    }

    public function pin($id)
    {
        $data = Payment::findOrFail($id);

        if ($data) {
            Payment::where('id', '!=', $id)->update(['default' => 0]);

            $data->default = 1;
            $data->save();

            toast('Pinned Successfully', 'success');
        } else {
            Alert::error('Error', 'Record not found');
        }
        return redirect()->back();
    }

    public function handlerAdd(Request $request)
    {

        try {
            $data = new handler();

            $data->name = $request->input('name');
            $data->save();

            toast('Hander added successful.', 'success');

            return back();
        } catch (Exception $e) {
            Alert::error('Error', 'Something Wrong..');
            return back();
        }
    }

    public function deleteReceipt($id)
    {
        try {
            $data = Modelreceipt::findOrFail($id);
            $invoice_no = $data->invoiceNumber;

            $invoice = Invoice::where('invoiceNumber', $invoice_no)->firstOrFail();
            $invoice->update(['status' => 7]);

            InvoiceDetails::where('invoiceNumber', $invoice_no)->update(['status' => 0]);

            $invoice = Invoice::where('invoiceNumber', $invoice_no)->first();

            // dd($invoice);

            $data->delete();

            Alert::success('Success', 'Receipt deleted successfully.');
        } catch (\Exception $e) {
            Alert::error('Error', 'Failed to delete receipt. Please try again.');
        }

        return redirect()->back();
    }
}

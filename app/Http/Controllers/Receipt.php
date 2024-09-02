<?php

namespace App\Http\Controllers;
use App\Models\CompanyDetails;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\Modelreceipt;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Alert;
use Carbon\Carbon;
use Dompdf\Dompdf;

class Receipt extends Controller
{
    public function generateReciept($id)
    {
        $company = Invoice::findOrFail($id);

        return view('User1.Receipt', compact('company'));
    }

    public function generateReceiptForm($id)
    {
        try {
            $company_data = Invoice::findOrFail($id);
            if ($company_data) {
                $address = $company_data->address;

                $selected_invoice_details = Invoice::where('address', $address)->pluck('invoiceNumber')->toArray();

                $invoiceNumbers = Invoice::where('address', $address)->pluck('invoiceNumber')->toArray();

                $invoice_data = InvoiceDetails::whereIn('invoiceNumber', $invoiceNumbers)->get();

                $invoiceNumber = $company_data->invoiceNumber;

                // dd($invoiceNumber);
            }
            return view('User1.recepitGenerate', compact('company_data', 'invoice_data', 'invoiceNumber'));
        } catch (\Exception $e) {
            return back()->with('error', 'Invoice not found.');
        }
    }

    public function receiptSettlement(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'id' => 'required',
        ]);

        $id = $request->input('id');
        $description = $request->input('description');

        $data = findOrFail::InvoiceDetails($id);
        if ($data) {
            $data->secAddress = $description;
            $data->save();

            toast('Something Wrong.', 'error');
            return back();
            // return redirect('custom/Reciept');
        } else {
            return back();
        }
    }

    //     public function receiptSettlement(Request $request)
    //     {
    //         $request->validate([
    //             'invoiceNumber' => 'required',
    //             'balance' => 'required',
    //             'invoice_data' => 'required',
    //         ]);

    //         $invoiceNumber = $request->input('invoiceNumber');
    //         $balance = $request->input('balance');
    //         $invoice_data = $request->input('invoice_data');
    //         $lastRow = $request->input('lastRow');

    //         $idArray = [];

    //             if($balance == 0)
    //             {
    //                 foreach($invoice_data as $get)
    //                 {
    //                     $data = InvoiceDetails::findOrFail($get->id);
    //                     $data->isReceipt = 3;
    //                     $data->save();
    //                     $idArray[] = $get->id;
    //                 }
    //             }
    //             elseif($balance >= 1)
    //             {
    // // 0772172244 - chandana.
    //             }
    //             else
    //             {

    //             }
    //     }

    public function CustomReceiptTest(Request $request)
    {
        $request->validate([
            'balance' => 'required|numeric',
        ]);

        $payment = $request->input('balance', []);
        $selectedItems = $request->input('selected_items', []);
        $method = $request->input('payment');

        if (empty($selectedItems)) {
            Alert::error('Error', 'No items selected.')->persistent(true);

            return redirect()->back()->with('bad', 'No items selected.');
        }

        $invoice_data = InvoiceDetails::whereIn('id', $selectedItems)->get();

        foreach ($invoice_data as $data) {
            $invo_data = InvoiceDetails::findOrFail($data->id);
            $invo_data->status = 1;
            $invo_data->isReceipt = 1; // 1 = generate but not in receipt.
            $invo_data->save();
        }

        if ($invoice_data->isEmpty()) {
            Alert::error('Error', 'No invoice data found for selected items.');

            return redirect()->back()->with('bad', 'No invoice data found for selected items.');
        }

        $firstInvoiceNumber = $invoice_data[0]->invoiceNumber;

        $Invoice = Invoice::where('invoiceNumber', $firstInvoiceNumber)->first();

        if (!$Invoice) {
            Alert::error('Error', 'Invoice not found for the retrieved invoice number.');
            return redirect()->back()->with('bad', 'Invoice not found for the retrieved invoice number.');
        }

        $additional = $request->input('additionalcharges');

        $lastReceiptId = ModelReceipt::max('id');

        $nextNumber = $lastReceiptId == 9999 ? 10000 : $lastReceiptId + 1;

        $formattedNumber = 'R' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $receipt = new Modelreceipt();

        $receipt->invoiceNumber = $firstInvoiceNumber;
        $receipt->receiptNumber = $formattedNumber;

        if ($additional == '') {
            $additional = 0;
        }
        $receipt->additional = $additional;
        $receipt->payedDate = Carbon::now();

        $receipt->save();

        $total = 0.0;

        foreach ($invoice_data as $get) {
            if ($get->currancy == 1) {
                $price = $get->price * $get->dollerRate;
            } else {
                $price = $get->price;
            }

            $total += $price;
        }

        return view('Invoice.settlement', compact('invoice_data', 'Invoice', 'method', 'payment', 'formattedNumber', 'total'));
        // $html = view('Invoice.pdfReceipt', compact('invoice_data', 'Invoice', 'method', 'payment', 'formattedNumber'))->render();

        // $dompdf = new Dompdf();

        // $dompdf->loadHtml($html);

        // $dompdf->setPaper('A4', 'portrait');

        // $dompdf->render();

        // $filename = str_replace('/', '-', $formattedNumber) . '.pdf';

        // file_put_contents(public_path('pdfs/' . $filename), $dompdf->output());

        // return view('Invoice.receiptModern', compact('invoice_data', 'Invoice', 'method', 'payment', 'formattedNumber'));
    }

    public function CustomReceipt(Request $request)
    {
        $request->validate([
            'balance' => 'required|numeric',
        ]);

        $payment = $request->input('balance', []);
        $selectedItems = $request->input('selected_items', []);
        $method = $request->input('payment');
        $formattedNumber = $request->input('receiptNo');

        if (empty($selectedItems)) {
            Alert::error('Error', 'No items selected.')->persistent(true);

            return redirect()->back()->with('bad', 'No items selected.');
        }

        $invoice_data = InvoiceDetails::whereIn('id', $selectedItems)->get();

        if ($invoice_data->isEmpty()) {
            Alert::error('Error', 'No invoice data found for selected items.');

            return redirect()->back()->with('bad', 'No invoice data found for selected items.');
        }
        $InvoTotal = 0.0;
        $companyID = 0;

        foreach ($invoice_data as $data) {
            $invo_data = InvoiceDetails::findOrFail($data->id);
            // $invo_data->status = 1;

            if ($data->currency == 1) {
                $convertedPrice = $data->price * $data->dollarRate;
                $InvoTotal += $convertedPrice;
            } else {
                $InvoTotal += $data->price;
            }

            $invo_data->status = 1;
            $invo_data->save();
            // $invo_data->save();
        }

        $firstInvoiceNumber = $invoice_data[0]->invoiceNumber;

        $Invoice = Invoice::where('invoiceNumber', $firstInvoiceNumber)->first();

        if (!$Invoice) {
            Alert::error('Error', 'Invoice not found for the retrieved invoice number.');
            return redirect()->back()->with('bad', 'Invoice not found for the retrieved invoice number.');
        }

        $companyID = $Invoice->refID;

        $company_outstanding = CompanyDetails::findOrFail($companyID);
        $company_outstanding->outstanding -= $payment;
        // dd($payment);
        $company_outstanding->save();

        // =================================================================================
        $additional = $request->input('additionalcharges');

        // $lastReceiptId = ModelReceipt::max('id');

        // $nextNumber = $lastReceiptId == 9999 ? 10000 : $lastReceiptId + 1;

        // $formattedNumber = 'R' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $receipt = new Modelreceipt();

        $receipt->invoiceNumber = $firstInvoiceNumber;
        $receipt->receiptNumber = $formattedNumber;
        // $receipt->receiptNumber = $formattedNumber;

        if ($additional == '') {
            $additional = 0;
        }
        $receipt->additional = $additional;
        $receipt->payedDate = Carbon::now();

        $receipt->save();

        $html = view('Invoice.pdfReceipt', compact('invoice_data', 'Invoice', 'method', 'payment', 'formattedNumber'))->render();

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        $filename = str_replace('/', '-', $formattedNumber) . '.pdf';

        file_put_contents(public_path('pdfs/' . $formattedNumber), $dompdf->output());

        return view('Invoice.receiptModern', compact('invoice_data', 'Invoice', 'method', 'payment', 'formattedNumber'));
    }

    public function generateReceipt(Request $request)
    {
        $selected_invoice = $request->input('selected_invoice', []);
        $selected_invoice_details = InvoiceDetails::whereIn('invoiceNumber', $selected_invoice)->get();

        return view('User1.recepitGenerate', compact('selected_invoice_details'));
        // $invoiceNumber = $request->input('invoiceNumber');
        // $selectedItems = $request->input('selected_items');

        // $selectedItemsData = InvoiceDetails::whereIn('id', $selectedItems)->get();

        // foreach ($selectedItemsData as $item) {
        //     $item->status = 1;
        //     $item->save();
        // }

        // $company_data = Invoice::where('invoiceNumber', $invoiceNumber)->first();
        // $invoiceNumber = $company_data->invoiceNumber;
        // $invoice_data = InvoiceDetails::where('invoiceNumber', $invoiceNumber)->get();
    }

    public function showReceipt($id)
    {
        $Invoice = CompanyDetails::findOrFail($id);

        $firstInvoiceNumber = Invoice::where('refID', $id)->first();

        $lastReceiptId = ModelReceipt::max('id');

        $nextNumber = $lastReceiptId == 9999 ? 10000 : $lastReceiptId + 1;

        $formattedNumber = 'R' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $receipt = new Modelreceipt();

        $receipt->invoiceNumber = $firstInvoiceNumber->invoiceNumber;
        $receipt->receiptNumber = $formattedNumber;
        $receipt->offline = 1;

        // $receipt->additional = $additional;
        $receipt->payedDate = Carbon::now();

        $receipt->save();

        $isSubmit = false;

        return view('invoice.receiptModernTwo', compact('Invoice', 'formattedNumber', 'isSubmit'));
    }

    public function paymentSubmit(Request $request)
    {
        try {
            $payment = $request->input('payment');
            $id = $request->input('companyID');
            $formattedNumber = $request->input('billNo');
            $OldformattedNumber = $request->input('OldbillNo');

            $oldReceiptNo = Modelreceipt::where('receiptNumber', $OldformattedNumber)->first();
            $oldReceiptNo->receiptNumber = $formattedNumber;
            $oldReceiptNo->save();

            $Invoice = CompanyDetails::findOrFail($id);
            $Invoice->outstanding -= $payment;
            $Invoice->save();

            $isSubmit = true;

            toast('Success', 'success');

            return view('invoice.receiptModernTwo', compact('Invoice', 'formattedNumber', 'isSubmit'));

        } catch (Exception $e) {

            Alert::error('Error', 'Something went wrong..');
            return back();
        }
    }
}

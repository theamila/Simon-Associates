<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyDetails;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\payment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Storage;
use Alert;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Dompdf\Dompdf;
use Carbon\Carbon;
use Exception;

class invoiceController extends Controller
{
    public function NewInvoice()
    {
        $data = CompanyDetails::all();

        $name = "";

        return view('User1.newInvoice', compact('data', 'name'));
    }

    public function RegisterCompanySave(Request $request)
    {
        try {
            $request->validate([
                'to' => 'required',
                'email' => 'required',
                'companyName' => 'required',
                'address' => 'required',
            ]);

            $data = new CompanyDetails();

            $data->to = $request->input('to');
            $data->email = $request->input('email');
            $data->companyName = $request->input('companyName');
            $data->address = $request->input('address');
            $data->handleBy = $request->input('handlBy');

            $data->save();

            Alert::success('Success', 'Company Registered Successfully');

            return back();
        } catch (\Exception $e) {
            Alert::error('Error', 'An error occurred while registering the company.');

            return back();
        }
    }

    public function invoiceDataAdd(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric',
        ]);

        try {
            $data = new InvoiceDetails();

            if ($request->input('toggle')) {
                $data->Reimbursables = 1;
            } else {
                $data->Reimbursables = 0;
            }
            $data->description = $request->input('description');
            $data->price = $request->input('price');
            $data->discount = $request->input('discount');
            $data->invoiceNumber = $request->input('invoiceNumber');
            $data->nom = $request->input('NOM');
            $data->pom = $request->input('POM');
            $data->sdate = $request->input('sdate');

            $data->save();

            toast('Invoice Data added successfully.', 'success');

            return back();
        } catch (\Exception $e) {
            return back()->with('bad', 'Error while Invoice Data add.' . $e);
        }
    }

    public function invoiceGenForm($invoiceNumber)
    {
        $invoiceNumber = str_replace('-', '/', $invoiceNumber);

        try {
            $company_data = Invoice::where('invoiceNumber', $invoiceNumber)->first();
            $outdata = CompanyDetails::findOrFail($company_data->refID);
            $invoice_data = InvoiceDetails::where('invoiceNumber', $company_data->invoiceNumber)->get();
            $bank = payment::all();

            return view('User1.generateInvoice', compact('invoice_data', 'company_data', 'invoiceNumber', 'outdata', 'bank'));
        } catch (\Exception $e) {
            return back()->with('bad', 'Something Wrong.');
        }
    }

    public function invoiceEditDataSave(Request $request, $id)
    {
        try {
            $data = InvoiceDetails::findOrFail($id);

            // $invoData = Invoice::where('invoiceNumber', $data->invoiceNumber)->first();
            // $invo_data->status = 9;
            // $invo_data->save();

            $data->description = $request->input('description');
            $data->price = $request->input('price');
            $data->discount = $request->input('discount');
            $data->invoiceNumber = $request->input('invoiceNumber');
            $data->nom = $request->input('NOM');
            $data->pom = $request->input('POM');
            $data->sdate = $request->input('sdate');

            if ($request->input('cstoggle')) {
                $data->Reimbursables = 1;
            } else {
                $data->Reimbursables = 0;
            }

            $data->save();

            return back()->with('good', 'Invoice Data Edit Successfully');
        } catch (\Exception $e) {
            return back()->with('bad', 'Error While Edit Data' . $e);
        }
    }

    public function sendToApprover($invoiceNumber, $bankId)
    {
        try {

            $invoiceNumber = str_replace('-', '/', $invoiceNumber);

            $data = Invoice::where('invoiceNumber', $invoiceNumber)->firstOrFail();
            $data->bankId = $bankId;
            $data->status = '2';
            $data->save();

            return redirect()->route('new-invoice')->with('good', 'Invoice successfully sent to the approver.');
        } catch (ModelNotFoundException $e) {
            return back()->with('bad', 'Something went wrong');
        } catch (\Exception $e) {
            return back()->with('bad', 'Something went wrong');
        }
    }

    public function deleteInvoiceData($id)
    {
        $invoice = InvoiceDetails::findOrFail($id);

        $invoice->delete();

        return redirect()->back()->with('good', 'Invoice data deleted successfully.');
    }

    public function NewInvoiceUser()
    {
        $data = Invoice::where('status', '2')->orWhere('status', '4')->get();

        return view('User2.newinvoice', compact('data'));
    }

    public function generateInvoiceFinal($id)
    {
        try {
            $company_data = Invoice::findOrFail($id);
            $invoice_data = InvoiceDetails::where('invoiceNumber', $company_data->invoiceNumber)->get();
            $invoiceNumber = $company_data->invoiceNumber;

            $bank = payment::all();

            return view('User1.Invoice', compact('company_data', 'invoice_data', 'invoiceNumber', 'bank'));
        } catch (\Exception $e) {
            return back()->with('error', 'Invoice not found.');
        }
    }

    public function generateInvoicePdf(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'currency' => 'required',
            'invoiceNo' => 'required',
            'dollarRate' => 'nullable|numeric',

        ]);

        try {
            $invoiceNumber = $request->input('invoiceNo');
            $date = $request->input('date');
            $currency = $request->input('currency');
            $bankID = $request->input('Selectbank');

            $dollarRate = $currency === 'USD' ? $request->input('dollarRate') : 1.0;

            $idArraySerialized = $request->input('id_array');
            $idArray = json_decode($idArraySerialized, true);

            foreach ($idArray as $id) {
                $invo_data = InvoiceDetails::findOrFail($id);
                if ($invo_data->convertToD == 0) {
                    $price = $invo_data->price - $invo_data->price * ($invo_data->discount / 100);
                    $priceInDollars = $price / $dollarRate;

                    $formattedPrice = number_format($priceInDollars, 2);

                    $formattedPrice = str_replace(',', '', $formattedPrice);

                    $invo_data->price = $formattedPrice;

                    $invo_data->currancy = $currency === 'USD' ? 1 : 0;
                    $invo_data->dollerRate = $currency === 'USD' ? $dollarRate : 1.0;

                    $invo_data->convertToD = 1;

                    $invo_data->save();
                }

                $invoice_data = InvoiceDetails::where('invoiceNumber', $invoiceNumber)->get();

                if ($invoice_data) {
                    foreach ($invoice_data as $data) {
                        $data->mark_status = 1;
                        $data->currancy = $currency === 'USD' ? 1 : 0;
                        // $data->dollerRate = $dollarRate;
                        $data->save();
                    }
                }
            }

            $company_data = Invoice::where('invoiceNumber', $invoiceNumber)->firstOrFail();
            $invoice_data = InvoiceDetails::where('invoiceNumber', $company_data->invoiceNumber)->get();

            $company_data->status = '7';
            $company_data->currency = $currency;
            $company_data->dollerRate = $dollarRate;
            $company_data->date = $date;
            $company_data->sendDate = Carbon::now('Asia/Colombo');
            $company_data->save();

            $bank = payment::findOrFail($company_data->bankId);

            $company_data = Invoice::where('invoiceNumber', $invoiceNumber)->firstOrFail();


            try {
                $txt = 'Account Name : ' . $bank->acName . ', Account Number : ' . $bank->accountNo . ', Bank Name : ' . $bank->bankName . ',  Bank Address : ' . $bank->bankAddress . ', Swift Code : ' . $bank->swiftCode;

                $qr = QrCode::size(150)->generate($txt);
            } catch (Exception $e) {
                return back();
            }

            // =================================================

            $html = view('Invoice.pdfinvoice', compact('invoiceNumber', 'company_data', 'date', 'dollarRate', 'invoice_data', 'bank', 'qr'))->render();

            $dompdf = new Dompdf();

            $dompdf->loadHtml($html);

            $dompdf->setPaper('A4', 'portrait');

            $dompdf->render();

            // $filename = str_replace('/', '-', $invoiceNumber) . '.pdf';



    $filename = str_replace('/', '-', $invoiceNumber) . '.pdf';
    $directoryPath = public_path('pdfs/invoices');

            // file_put_contents(public_path('pdfs/invoices/' . $filename), $dompdf->output());


            if (!is_dir($directoryPath)) {
                mkdir($directoryPath, 0755, true); // Ensure the directory exists
            }


    $filename = str_replace('/', '-', $invoiceNumber) . '.pdf';
    $directoryPath = public_path('pdfs/invoices');

    file_put_contents($directoryPath . '/' . $filename, $dompdf->output());
            // =================================================================

            return view('Invoice.modern', compact('invoiceNumber', 'company_data', 'date', 'dollarRate', 'invoice_data', 'bank', 'qr'));

            // return view('Invoice.Invoice', compact('invoiceNumber', 'company_data', 'date', 'dollarRate', 'invoice_data'));
        } catch (\Exception $e) {
            Alert::error('Error', 'Something went wrong.' . $e);

            return back();
        }
    }

    public function addComment(Request $request)
    {
        try {
            $data = InvoiceDetails::findOrFail($request->input('id'));
            if ($data) {
                $data->remark = $request->input('remark');
                $data->save();
            } else {
                return back()->with('bad', 'Somthing Went Wrong.');
            }

            return back()->with('good', 'Remark Added successfully.');
        } catch (Exception $e) {
            return back()->with('bad', 'Somthing Went Wrong.');
        }
    }

    public function fixed($id)
    {
        $data = InvoiceDetails::findOrFail($id);
        if ($data) {
            $data->remark = '';
            $data->save();
            return back()->with('good', 'Fixed.');
        } else {
            return back()->with('bad', 'Something wrong.');
        }
    }
    public function sendInvoice($invoiceNumber)
    {
        try {
            $invoiceNumber = str_replace('-', '/', $invoiceNumber);

            $invoice = Invoice::where('invoiceNumber', $invoiceNumber)->first();

            if (!$invoice) {
                return back()->with('error', 'Invoice not found.');
            }

            $invoice->status = '6';
            $invoice->save();

            $outPriceTotal = 0.00; // Accumulator for total outstanding price
            $invoiceDetails = InvoiceDetails::where('invoiceNumber', $invoiceNumber)->get();

            foreach ($invoiceDetails as $invoiceDetail) {
                $dollarRate = $invoiceDetail->currency === 1 ? $invoiceDetail->dollarRate : 1.0;
                $outPrice = $invoiceDetail->price - $invoiceDetail->price * ($invoiceDetail->discount / 100);
                $outPrice = $outPrice / $dollarRate;
                $outPriceTotal += $outPrice;
            }

            // Update company outstanding amount
            $company = CompanyDetails::findOrFail($invoice->refID);
            $company->outstanding += $outPriceTotal;
            $company->save();

            return redirect()->route('generate-Invoice', $invoice->id);
        } catch (\Exception $e) {
            // Log the full exception for debugging
            \Log::error('Exception occurred while sending invoice: ' . $e->getMessage());
            return back()->with('bad', 'Something went wrong.');
        }
    }


    // public function sendInvoice($invoiceNumber)
    // {
    //     try {
    //         $invoiceNumber = str_replace('-', '/', $invoiceNumber);

    //         $invoice = Invoice::where('invoiceNumber', $invoiceNumber)->first();

    //         if ($invoice) {
    //             $invoice->status = '6';
    //             $invoice->save();

    //             $outPrice = 0.00;
    //             $outData = InvoiceDetails::where('invoiceNumber', $invoiceNumber)->get();
    //             if ($outData) {
    //                 foreach($outData as $get)
    //                 {
    //                     $dollarRate = $get->currency === 1 ? $get->dollerRate : 1.0;
    //                     $outPrice = $get->price - $get->price * ($get->discount / 100);
    //                     $outPrice = $outPrice / $dollarRate;
    //                 }

    //                 $company = CompanyDetails::findOrFail($invoice->refID);
    //                 $company->outstanding = $outData;
    //                 $company->save();
    //             }

    //             return redirect()->route('generate-Invoice', $invoice->id);
    //         } else {
    //             return back()->with('error', 'Invoice not found.');
    //         }
    //     } catch (Exception $e) {
    //         return back()->with('bad', 'Something Wrong..');
    //     }
    // }

    public function reSend($id)
    {
        $invoice = Invoice::findOrFail($id);

        if ($invoice) {
            $invoice->resend = 1;
            $invoice->save();

            $invoiceNumber = $invoice->invoiceNumber;
            $invoice_data = InvoiceDetails::where('invoiceNumber', $invoiceNumber)->get();

            return view('User1.editInvoicer', compact('invoice', 'invoice_data', 'invoiceNumber'));
        } else {
            Alert::error('Error', 'Unble to find Invoice.');
        }
    }

    public function recentHome($invoiceNumber)
    {
        $invoiceNumber = str_replace('-', '/', $invoiceNumber);

        try {
            $company_data = Invoice::where('invoiceNumber', $invoiceNumber)->first();
            $invoice_data = InvoiceDetails::where('invoiceNumber', $company_data->invoiceNumber)->get();
            $outdata = CompanyDetails::findOrFail($company_data->refID);
            $bank = payment::all();


            return view('User1.generateInvoice', compact('invoice_data', 'company_data', 'invoiceNumber', 'outdata', 'bank'));
        } catch (\Exception $e) {
            return back()->with('bad', 'Something Wrong.');
        }
    }

    public function changeBank(Request $request)
    {
        $id = $request->input('Selectbank');

        $invoiceNumber = $request->input('invoiceNumber');

        $data = Invoice::where('invoiceNumber', $invoiceNumber)->first();
        $data->bankId = $id;
        $data->save();
        return back();
    }

    public function SearchCustomer(Request $request)
    {
        try
        {
            $request->validate([
                'name' => 'required',
            ]);

            $name = $request->input('name');
           $data = CompanyDetails::where('companyName', 'like', "%$name%")->get();

            if ($data->isEmpty()) {

                toast('No company found with the given name.', 'error');

                return back();
            }

            return view('User1.newInvoice', compact('data', 'name'));

        }
        catch(\Exception $e)
        {
            toast('Something went wrong. Please try again later.', 'error');
            return back();
        }
    }
}

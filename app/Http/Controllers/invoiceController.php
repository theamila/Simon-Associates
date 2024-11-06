<?php

namespace App\Http\Controllers;

use Alert;
use App\Models\CompanyDetails;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\payment;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class invoiceController extends Controller
{

    public function rejectInvoiceUser()
    {
        $data = Invoice::where('status', 9)->orderBy('id', 'desc')->paginate(100);

        return view('User2.rejected', compact('data'));
    }

    public function NewInvoice()
    {
        $data = CompanyDetails::where('state', true)->get();

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
            Alert::error('Error', 'An error occurred while registering the company.' . $e);

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

            DB::beginTransaction();

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

            $bankinvoice = Invoice::where('invoiceNumber', $request->input('invoiceNumber'))->first();
            $bankinvoice->refID = $request->input('Selectbank');

            $data->save();
            $bankinvoice->save();

            DB::commit();

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
            $outdata = CompanyDetails::findOrFail($company_data->customerRefId);
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

            return redirect('/dashboard')->with('good', 'Invoice successfully sent to the approver.');
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
        $data = Invoice::where('status', '2')->orWhere('status', '4')->orWhere('status', '6')->get();

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
            $company_data->sendDate = Carbon::now('Asia/Colombo')->format('Y-m-d');

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


            return view('Invoice.modern', compact('invoiceNumber', 'company_data', 'date', 'dollarRate', 'invoice_data', 'bank', 'qr', 'currency'));

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
    public function sendInvoiceLast($invoiceNumber)
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
            $company = CompanyDetails::findOrFail($invoice->customerRefId);
            $company->outstanding += $outPriceTotal;
            $company->save();

            return redirect()->route('generate-Invoice', $invoice->id);
        } catch (\Exception $e) {
            // Log the full exception for debugging
            \Log::error('Exception occurred while sending invoice: ' . $e->getMessage());
            return back()->with('bad', 'Something went wrong.');
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

            toast('Success', 'success');

            Alert::success('Success', 'success');

            return redirect('/ongoing/invoice');

            // $outPriceTotal = 0.00; // Accumulator for total outstanding price
            // $invoiceDetails = InvoiceDetails::where('invoiceNumber', $invoiceNumber)->get();

            // foreach ($invoiceDetails as $invoiceDetail) {
            //     $dollarRate = $invoiceDetail->currency === 1 ? $invoiceDetail->dollarRate : 1.0;
            //     $outPrice = $invoiceDetail->price - $invoiceDetail->price * ($invoiceDetail->discount / 100);
            //     $outPrice = $outPrice / $dollarRate;
            //     $outPriceTotal += $outPrice;
            // }

            // Update company outstanding amount
            // $company = CompanyDetails::findOrFail($invoice->refID);
            // $company->outstanding += $outPriceTotal;
            // $company->save();

            // return redirect()->route('generate-Invoice', $invoice->id);
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

            $bank = payment::all();

            return view('User1.editInvoicer', compact('invoice', 'invoice_data', 'invoiceNumber', 'bank'));
        } else {
            Alert::error('Error', 'Unble to find Invoice.');
        }
    }

    public function recentHome($invoiceNumber)
    {
        $invoiceNumber = str_replace('-', '/', $invoiceNumber);

        try {
            $company_data = Invoice::where('invoiceNumber', $invoiceNumber)->first();

            // Check if $company_data exists before proceeding
            if (!$company_data) {
                $invoiceNumber = str_replace('/', '-', $invoiceNumber);
                $company_data = Invoice::where('invoiceNumber', $invoiceNumber)->first();

                if (!$company_data) {

                    return back()->with('error', 'No invoice found with the given invoice number.' . $invoiceNumber);
                }
                $invoiceNumber = str_replace('-', '/', $invoiceNumber);
            }

            // Retrieve invoice details
            $invoice_data = InvoiceDetails::where('invoiceNumber', $company_data->invoiceNumber)->get();

            // Retrieve company details (findOrFail will throw an exception if not found)
            $outdata = CompanyDetails::findOrFail($company_data->customerRefId);

            // Retrieve all payment information
            $bank = Payment::all();

            return view('User1.generateInvoice', compact('invoice_data', 'company_data', 'invoiceNumber', 'outdata', 'bank'));
        } catch (\Exception $e) {
            // dd($invoiceNumber);
            dd($e->getMessage());
            return back()->with('error', 'Something Wrong.' . $e->getMessage());
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
        try {
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
        } catch (\Exception $e) {
            toast('Something went wrong. Please try again later.', 'error');
            return back();
        }
    }

    public function recentDelete($id)
    {
        try {
            // Find the invoice or throw a 404 exception if not found
            $data = Invoice::findOrFail($id);

            // Retrieve the invoice number before deleting the invoice
            $deleteInvoiceNumber = $data->invoiceNumber;

            // Retrieve all related invoice details
            $deleteInvoiceData = InvoiceDetails::where('invoiceNumber', $deleteInvoiceNumber)->get();

            if (!$deleteInvoiceData->isEmpty()) {
                foreach ($deleteInvoiceData as $invoiceDetail) {
                    $invoiceDetail->delete();
                }
            }

            $data->delete();

            // Reset auto-increment value
            DB::statement("ALTER TABLE invoices AUTO_INCREMENT = 1");

            toast('Invoice Deleted successfully.', 'success');

            return back();
        } catch (Exception $e) {
            toast('Failed to delete the invoice.', 'error');

            return back();
        }
    }

    public function rejectInvoice($invoiceNumber)
    {
        $invoiceNumber = str_replace('-', '/', $invoiceNumber);

        $data = Invoice::where('invoiceNumber', $invoiceNumber)->first();

        $data->status = 9;
        $data->save();

        Alert::success('Success', 'Invoice Rejected Successfully');

        return redirect('/new-invoice-user-tree');
    }

    public function deleteInvoice($id)
    {
        try {
            $invoice = Invoice::find($id);

            if (!$invoice) {
                Alert::error('Error', 'Unable to find Invoice.');
                return back();
            }

            $invoiceDetails = InvoiceDetails::where('invoiceNumber', $invoice->invoiceNumber)->get();
            $price = $invoiceDetails->sum('price');



            $company = CompanyDetails::find($invoice->customerRefId);

            if (!$company) {
                Alert::error('Error', 'Customer Not found.');
                return back();
            }

            // Calculate new outstanding price
            $newOutstanding = $company->outstanding - $price;

            // Ensure outstanding doesn't go below zero if your business rules require it
            // Example logic to prevent negative outstanding:
            // $newOutstanding = max(0, $newOutstanding);

            $company->outstanding = $newOutstanding;
            $company->save();
            foreach ($invoiceDetails as $detail) {
                $detail->delete();
            }
            $invoice->delete();

            Alert::success('Success', 'Invoice deleted Successfully.');

            return redirect('/2/outstanding/view');
        } catch (Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect('/2/outstanding/view');
        }
    }


    public function editInvoiceNumber(Request $req, $id)
    {
        // Retrieve the new invoice number from the request
        $oldInvoiceNumber = $req->input('oldInvoiceNumber');
        $invoiceNumber = $req->input('invoiceNumber');

        // Find the invoice by its ID
        $invoiceData = Invoice::find($id);

        // Ensure the invoice exists
        if ($invoiceData) {
            // Update the invoice number for the main invoice table
            $invoiceData->invoiceNumber = $invoiceNumber;
            $invoiceData->save();

            // Find all related invoice details and update them
            $invoiceDetail = InvoiceDetails::where('invoiceNumber', $oldInvoiceNumber)->get();

            foreach ($invoiceDetail as $item) {
                // Update each related record's invoice number
                $item->invoiceNumber = $invoiceNumber;
                $item->save();
            }

            // Optionally, return a success message or redirect
            return redirect()->back()->with('success', 'Invoice number updated successfully!');
        }

        // Optionally, return an error message if the invoice is not found
        return redirect()->back()->with('error', 'Invoice not found.');
    }


    public function editnewInvoiceNumber(Request $req, $id)
    {

        $oldInvoiceNumber = str_replace('-', '/', $req->input('oldInvoiceNumber'));

        // dd($oldInvoiceNumber);

        $invoiceNumber = str_replace('-', '/', $req->input('invoiceNumber'));

        // Find the invoice by its ID
        $invoiceData = Invoice::find($id);

        // Ensure the invoice exists
        if ($invoiceData) {
            // Update the invoice number for the main invoice table
            $invoiceData->invoiceNumber = $invoiceNumber;
            $invoiceData->save();

            // Find all related invoice details and update them
            $invoiceDetail = InvoiceDetails::where('invoiceNumber', $oldInvoiceNumber)->get();

            foreach ($invoiceDetail as $item) {
                // Update each related record's invoice number
                $item->invoiceNumber = $invoiceNumber;
                $item->save();
            }

            $invoiceNumber = str_replace('/', '-', $invoiceNumber);

            // Optionally, return a success message or redirect
            return redirect('invoice/' . $invoiceNumber);
        }
    }

    public function deleteinvoiceadmin($invoiceNUmber)
    {
        $invoiceNumber = str_replace('-', '/', $invoiceNUmber);

        try {
            $invoice = Invoice::where('invoiceNumber', $invoiceNumber)->first();

            if ($invoice) {
                $invoice->delete();

                $invoiceDetails = InvoiceDetails::where('invoiceNumber', $invoiceNumber)->get();
                foreach ($invoiceDetails as $item) {
                    $item->delete();
                }

                Alert::success('Success', 'Invoice Deleted Successfully');
                return redirect('new/invoice/approvel');
            } else {
                Alert::error('Error', 'Invoice not found');
                return redirect()->back();
            }
        } catch (Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function rejectResend($oldinvoiceNumber){
        $invoiceNumber = str_replace('-', '/', $oldinvoiceNumber);

        $invoice = Invoice::where('invoiceNumber', $invoiceNumber)->first();
        $invoice->status = 1;
        $invoice->save();

        return redirect('/invoice/' . $oldinvoiceNumber);

    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;


class PDFController extends Controller
{
    //
    public function upload(Request $request)
    {
        if ($request->hasFile('pdf')) {

            $file = $request->file('pdf');
            $filename = $file->getClientOriginalName();
            $path = 'public/pdfs/' . $filename;

            if (Storage::exists($path)) {
                Storage::delete($path);
            }



           $path = $file->storeAs('public/pdfs', $filename);

            return response()->json(['success' => true]);

            //return response()->json(['message' => 'PDF uploaded successfully', 'path' => $path]);
        }

       Alert::error('No file uploaded');
         return response()->json(['message' => ''], 400);
    }


    public function uploadInvoice(Request $request)
    {
        if ($request->hasFile('pdf')) {
            $file = $request->file('pdf');
            $filename = $file->getClientOriginalName();
            $path = 'public/invoices/'.$filename;

            // Delete the file if it already exists
            if (Storage::exists($path)) {
                Storage::delete($path);
            }

            // Store the new file
            $file->storeAs('public/invoices', $filename);

            return response()->json(['message' => 'PDF uploaded successfully', 'path' => $path]);
        }

        return response()->json(['message' => 'No file uploaded'], 400);
    }

}

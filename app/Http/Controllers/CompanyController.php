<?php

namespace App\Http\Controllers;

use App\Models\CompanyDetails;
use App\Models\Invoice;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:company_details,id',
            'to' => 'required|string',
            'email' => 'required',
            'companyName' => 'required|string',
            'handleBy' => 'required|integer|exists:handlers,id',
            'address' => 'required|string',
        ]);

        $company = CompanyDetails::findOrFail($request->id);
        $company->update([
            'to' => $request->to,
            'email' => $request->email,
            'phone' => $request->phone,
            'companyName' => $request->companyName,
            'address' => $request->address,
            'handleBy' => $request->handleBy,
        ]);

        Invoice::where('customerRefId', $request->id)->update([
            'to' => $request->to,
            'email' => $request->email,
            'companyName' => $request->companyName,
            'address' => $request->address,
        ]);

        return redirect()->back()->with('success', 'Company details updated successfully!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\CompanyDetails;
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

    $company = CompanyDetails::find($request->id);
    $company->to = $request->to;
    $company->email = $request->email;
    $company->companyName = $request->companyName;
    $company->address = $request->address;
    $company->handleBy = $request->handleBy;
    $company->save();

    return redirect()->back()->with('success', 'Company details updated successfully!');
}

}

<?php

namespace App\Http\Controllers;

use App\Models\CompanyDetails;
use Exception;
use Illuminate\Http\Request;
use Alert;

class customerController extends Controller
{
    public function on($id)
    {
        try {
            $data = CompanyDetails::findOrFail($id);
            $data->state = true;
            $data->save();

            toast('Customer Deactivation Successfully', 'success');
            return redirect('/update');
        } catch (Exception $e) {
            toast('Something wrong...', 'error');
            return back();
        }
    }


    public function off($id)
    {
        try {
            $data = CompanyDetails::findOrFail($id);
            $data->state = false;
            $data->save();

            toast('Customer Activation Successfully', 'success');
            return redirect('/update');
        } catch (Exception $e) {
            toast('Something wrong...', 'error');
            return back();
        }
    }
}

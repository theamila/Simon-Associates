<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class login extends Controller
{
    public function login()
    {
        return view('Login.login');
    }

    public function loginCheck(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        if ($email == 'user1@gmail.com' && $password == 'aaaa') {
            Session::put('username', $email);
            return redirect('/dashboard');
        } elseif ($email == 'user2@gmail.com' && $password == 'aaaa') {
            Session::put('username', $email);
            return redirect('/user2');
        } elseif ($email == 'user3@gmail.com' && $password == 'aaaa') {
            Session::put('username', $email);
            return redirect('/user3');
        } else {
            return back();
        }
    }

    public function migrate()
    {

        \Artisan::call('migrate');

        return response()->json(['message' => 'Database migration completed successfully.']);
    }
}

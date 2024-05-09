<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Hash;
use Alert;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            switch ($user->role) {
                case User::ROLE_USER:
                    return redirect()->route('dashboard');
                    break;
                case User::ROLE_FINANCE:
                    return redirect()->route('user2');
                    break;
                case User::ROLE_APPROVER:
                    return redirect()->route('Home');
                    break;
                default:
                    return redirect('/login')->withErrors(['login_error' => 'Invalid role']);
            }
        }

        return redirect()->back()->withErrors(['login_error' => 'Invalid email or password']);
    }


    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3|confirmed',
            'role' => 'required|in:' . implode(',', [
                User::ROLE_USER,
                User::ROLE_FINANCE,
                User::ROLE_APPROVER,
            ]),
        ]);

        try
        {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role, 
            ]);
    
            if($user)
            {
                Alert::success('Success', 'User Registration successful!');
    
                return redirect()->back();
            }
            
        }

        catch(QueryException $e)
        {
            Alert::error('Error', 'Registration failed!');
            
            return redirect()->back();
        }

        
    }

    public function logout()
    {
        Auth::logout();
        
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }

}

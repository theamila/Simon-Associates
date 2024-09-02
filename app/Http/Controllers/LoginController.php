<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\otp;
use Hash;
use Alert;
use App\Mail\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{


    public function otpView(Request $request)
{
    $email = $request->query('email');
    return view('auth.otp', compact('email'));
}



    public function newPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:4|confirmed',
            'email' => 'required',
        ]);

         $email = $request->input('email');
         $data = User::where('email', $email)->first();

         if($data){
            $data->password = Hash::make($request->password);
            $data->save();

            return redirect('login');
         }
         else{
            return back();
         }

    }
    public function verifyotp(Request $request)
    {

        $otpArray = $request->input('otp'); // This returns an array
        $otp = implode('', $otpArray);

        $email = $request->input('email');

        if($otp && $email)
        {
            $data = otp::where('email', $email)->first();
            if($data)
            {
                if($data->token == $otp)
                {
                   return view('auth.newpassword', compact('email'));
                }
                else
                {
                    return back();
                }
            }
            else
            {
                return redirect('/login')->with('error', 'Something Wrong..');
            }
        }
        else
        {
            return redirect('/login')->with('error', 'Something Wrong..');
        }

    }
    public function passwordResetSend(Request $request)
    {
        // Validate the email
        $request->validate(['email' => 'required|email']);

        $email = $request->input('email');

        // Find the user by email
        $data = User::where('email', $email)->first();

        if ($data) {
            // Generate a 4-digit OTP
            $otp = rand(1000, 9999);

            // Store the OTP in the database (you might need to create the 'otp' table if it doesn't exist)
            DB::table('otps')->updateOrInsert(
                ['email' => $email],
                [
                    'email' => $email,
                    'token' => $otp,
                    'created_at' => now(),
                ]
            );


            $details = [
                'otp' => $otp,
            ];

            // Send the OTP email
            Mail::to($email)->send(new PasswordReset($details));

            return redirect()->route('otp.view',  ['email' => $email]);

            // return view('auth.otp', compact('email'));

        } else {
            return back()->with('error', 'User not registered. Please check the email again.');
        }
    }

    public function passwordReset()
    {
        return view('auth.passwordReset');
    }
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

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            if ($user) {
                Alert::success('Success', 'User Registration successful!');

                return redirect()->back();
            }
        } catch (QueryException $e) {
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

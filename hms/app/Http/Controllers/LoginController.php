<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use App\Models\User;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        return view('login.index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('name', 'password');

        if (Auth::attempt($credentials)) {
            // Regenerate Session ID
            $request->session()->regenerate();

            // Get the authenticated user
            $user = Auth::user();

            // Redirect based on user role
            if ($user->hasRole('super admin')) {
                return response()->json([
                    'state' => 'success',
                    'redirect' => route('admin.dashboard')
                ]);
            } elseif ($user->hasRole('admin')) {
                return response()->json([
                    'state' => 'success',
                    'redirect' => route('admin.dashboard')
                ]);
            } elseif ($user->hasRole('doctor')) {
                return response()->json([
                    'state' => 'success',
                    'redirect' => route('doctor.dashboard')
                ]);
            } elseif ($user->hasRole('pharmacist')) {
                return response()->json([
                    'state' => 'success',
                    'redirect' => route('pharmacist.dashboard')
                ]);
            } elseif ($user->hasRole('normal user')) {
                return response()->json([
                    'state' => 'success',
                    'redirect' => route('dashboard')
                ]);
            }
        }

        return response()->json([
            'state' => 'error',
            'message' => 'Incorrect credentials! Please try again.'
        ], 401);
    }

    public function create(Request $request)
    {
        // Path of error log file: C:\xampp\apache\logs\error.log

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Validate request
            $request->validate([
                'email' => 'required|email',
                'name' => 'required',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
            ]);

            // Run the select query to get the data in users table
            $users = DB::select('SELECT * FROM users');

            // Check is the email and name exists
            foreach ($users as $user) {
                if ($request->email == $user->email) {
                    return response()->json([
                        'state' => 'error',
                        'message' => 'This email is registered already!'
                    ]);
                }

                if ($request->name == $user->name) {
                    return response()->json([
                        'state' => 'error',
                        'message' => 'This username is registered already!'
                    ]);
                }
            }

            // Insert data into database
            $newuser = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password), // Hashing password
            ]);

            $newuser->assignRole('normal user');
            
            // Commit transaction
            DB::commit();

            return response()->json([
                'state' => 'success',
                'message' => 'User registered successfully!',
            ]);

        } catch (\Exception $e) {
            // Roll back the transaction if an exception occurs
            DB::rollback();

            // Returning error message
            return response()->json([
                'state' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Attempt to send the password reset link to the given email address
        $response = Password::sendResetLink($request->only('email'));

        // Check if the reset link was successfully sent
        if ($response === Password::RESET_LINK_SENT) {
            return response()->json([
                'state' => 'success',
                'message' => 'Reset password link sent successfully.'
            ]);
        } else {
            return response()->json([
                'state' => 'error',
                'message' => 'Failed to send reset password link.'
            ], 500);
        }
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.resetpassword')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    public function reset(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        // Attempt to reset the user's password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        // Check if the password was successfully reset
        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'state' => 'success',
                'message' => 'Password has been reset successfully.'
            ]);
        } else {
            return response()->json([
                'state' => 'error',
                'message' => __($status)
            ], 500);
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        // Log the user out
        Auth::logout();
    
        // Invalidate the user's session
        $request->session()->invalidate();
    
        // Regenerate the session token
        $request->session()->regenerateToken();
    
        // Redirect the user to the login page
        return redirect('/');
    }
}
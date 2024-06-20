<?php

namespace App\Http\Controllers;

use App\Http\Controllers\authentications\TwoStepsCover;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class LoginRegisterController extends Controller
{
    public function authenticate(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return redirect()->route('index')
                    ->withSuccess('You have successfully logged in!');
            }
            return back()->withErrors([
                'email' => 'Your provided credentials do not match in our records.',
            ])->onlyInput('email');
        } else {
            return back()->withErrors("you are not aright role contact to admin");
        }
    }
    public function login()
    {
        return view('login');
    }

    public function register()
    {
        return view('registration');
    }

    public function logout(Request $request)
    {
        $role = Auth::user()->role;
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // if ($role == 'admin' || $role == 'account' || $role == 'warehouse') {
        //     $routeName = 'auth-login-basic';
        // } else {
        //     $routeName = 'auth-login-cover';
        // }
        return redirect()->route('login')
            ->withSuccess('You have logged out successfully!');;
    }
    public function store(Request $request)
    {

        // dd($request->all());
        $this->validate(request(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        $User = User::where('email', $request->email)->first();

        if (empty($User)) {
            $password = Hash::make($request->password);
            $User = new User([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $password,
                'role' => $request->role,
            ]);

            $User->save();
            if ($User) {
                $success = 'Registerd';
                return redirect()->route('login', compact('success'))
                    ->withSuccess('Registered');
            }
        } else {
            $error = 'Email already exists';
            return redirect()->route('login', compact('error'))
                ->withSuccess('Registered');
        }
    }
}

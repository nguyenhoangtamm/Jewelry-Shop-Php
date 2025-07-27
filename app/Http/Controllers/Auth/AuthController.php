<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('auth.login');
    }

    public function registerView()
    {
        return view('auth.register');
    }
    public function login(Request $request)
    {
        // Logic for handling login
        $credentials = $request->only('login_field', 'password');
        // Assuming 'login_field' can be either 'username' or 'email'
        if (filter_var($credentials['login_field'], FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $credentials['login_field'];
            unset($credentials['login_field']);
        } else {
            $credentials['username'] = $credentials['login_field'];
            unset($credentials['login_field']);
        }
        if (Auth::attempt($credentials)) {
            // Authentication passed
            return redirect()->intended(route('home'));
        } else {
            // Authentication failed
            return back()->withErrors([
                'email' => 'Invalid credentials.',
            ]);
        }
    }
    public function register(Request $request)
    {
        // Logic for handling registration
        $data = $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone_number' => 'required|digits:10',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);
        $data['password'] = bcrypt($data['password']);
        User::create($data);

        return $this->loginView()->with('success', 'Đăng ký thành công! Bạn có thể đăng nhập.');
    }
}

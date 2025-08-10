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
        if (Auth::check()) {
            // Nếu đã đăng nhập, chuyển hướng về trang chính
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    public function registerView()
    {
        if (Auth::check()) {
            // Nếu đã đăng nhập, chuyển hướng về trang chính
            return redirect()->route('home');
        }
        return view('auth.register');
    }
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'login_field' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('login_field', 'password');

        // Determine if login_field is email or username
        if (filter_var($credentials['login_field'], FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $credentials['login_field'];
            unset($credentials['login_field']);
        } else {
            $credentials['username'] = $credentials['login_field'];
            unset($credentials['login_field']);
        }

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Authentication passed
            $request->session()->regenerate();
            $user = Auth::user();

            return response()->json([
                'success' => true,
                'message' => 'Đăng nhập thành công!',
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'fullname' => $user->fullname,
                    'role' => $user->role ?? 'user'
                ]
            ]);
        } else {
            // Authentication failed
            return response()->json([
                'success' => false,
                'message' => 'Thông tin đăng nhập không chính xác.'
            ], 401);
        }
    }
public function register(Request $request)
{
    try {
        // Validate input
        $data = $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone_number' => 'required|digits:10',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'username.unique' => 'Tên đăng nhập đã được sử dụng.',
            'email.unique' => 'Email đã được sử dụng.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'phone_number.digits' => 'Số điện thoại phải có đúng 10 chữ số.',
        ]);

        // Hash password
        $data['password'] = bcrypt($data['password']);

        // Gán role mặc định cho user mới
        $data['role'] = 'customer';

        // Create user
        $user = User::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Đăng ký thành công! Bạn có thể đăng nhập ngay bây giờ.'
        ]);
    } catch (\Illuminate\Validation\ValidationException $e) {
        return response()->json([
            'success' => false,
            'message' => 'Dữ liệu không hợp lệ.',
            'errors' => $e->errors()
        ], 422);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra trong quá trình đăng ký. Vui lòng thử lại.'
        ], 500);
    }
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Đăng xuất thành công!'
        ]);
    }
}

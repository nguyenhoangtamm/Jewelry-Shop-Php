<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /**
     * Hiển thị form quên mật khẩu
     */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Xử lý gửi email reset password
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.exists' => 'Email không tồn tại trong hệ thống.'
        ]);

        $user = User::where('email', $request->email)->first();

        // Tạo token reset
        $token = Str::random(64);

        // Xóa token cũ nếu có
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // Tạo token mới
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => Carbon::now()
        ]);

        // Gửi email
        try {
            Mail::send('auth.emails.password-reset', [
                'user' => $user,
                'token' => $token,
                'url' => route('password.reset', ['token' => $token, 'email' => $request->email])
            ], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Đặt lại mật khẩu - ' . config('app.name'));
            });

            return response()->json([
                'success' => true,
                'message' => 'Chúng tôi đã gửi link đặt lại mật khẩu đến email của bạn!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi gửi email. Vui lòng thử lại sau.'
            ], 500);
        }
    }

    /**
     * Hiển thị form reset password
     */
    public function showResetForm(Request $request)
    {
        $token = $request->route('token');
        $email = $request->email;

        return view('auth.reset-password', compact('token', 'email'));
    }

    /**
     * Xử lý reset password
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'email.exists' => 'Email không tồn tại trong hệ thống.',
            'password.required' => 'Vui lòng nhập mật khẩu mới.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
        ]);

        // Kiểm tra token
        $passwordReset = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        if (!$passwordReset) {
            return response()->json([
                'success' => false,
                'message' => 'Token không hợp lệ.'
            ], 400);
        }

        // Kiểm tra token có khớp không
        if (!Hash::check($request->token, $passwordReset->token)) {
            return response()->json([
                'success' => false,
                'message' => 'Token không hợp lệ.'
            ], 400);
        }

        // Kiểm tra token có hết hạn không (24 giờ)
        if (Carbon::parse($passwordReset->created_at)->addHours(24)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return response()->json([
                'success' => false,
                'message' => 'Token đã hết hạn. Vui lòng yêu cầu đặt lại mật khẩu mới.'
            ], 400);
        }

        // Cập nhật mật khẩu
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Xóa token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mật khẩu đã được đặt lại thành công!'
        ]);
    }
}

<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\ImageHelper;

class UserProfileController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('user.profile.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('user.profile.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone_number' => ['required', 'regex:/^[0-9]{10}$/', function ($attribute, $value, $fail) {
                // Kiểm tra không quá 5 số trùng nhau
                $digits = str_split($value);
                $digitCounts = array_count_values($digits);
                foreach ($digitCounts as $count) {
                    if ($count > 5) {
                        $fail('Số điện thoại không được có quá 5 chữ số giống nhau.');
                        break;
                    }
                }
            }],
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed',
        ]);

        // Kiểm tra mật khẩu hiện tại nếu muốn đổi mật khẩu
        if ($request->filled('new_password')) {
            if (!$request->filled('current_password') || !Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không đúng.']);
            }
        }

        // Xử lý upload avatar: lưu vào bảng files và lấy tên file (path) giống jewelry
        if ($request->hasFile('avatar')) {
            try {
                $fileModel = ImageHelper::uploadFile($request->file('avatar'), 'images');
                if ($fileModel) {
                    $user->avatar = $fileModel->path; // lưu tên file (path) từ bảng files
                }
            } catch (\Throwable $e) {
                return back()->withErrors(['avatar' => 'Không thể tải lên ảnh. Vui lòng thử lại.'])->withInput();
            }
        }

        // Cập nhật thông tin
        $user->username = $request->username;
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->date_of_birth = $request->date_of_birth;
        $user->address = $request->address;

        // Cập nhật mật khẩu nếu có
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return redirect()->route('profile.show', $id)->with('success', 'Thông tin cá nhân đã được cập nhật thành công!');
    }
}

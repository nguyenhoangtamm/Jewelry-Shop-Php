<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        
        return view('user.contact');

    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Xử lý logic gửi email hoặc lưu DB ở đây (nếu cần)

        return redirect()->back()->with('success', 'Gửi liên hệ thành công!');
    }
}
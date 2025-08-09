<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function index()
    {
        // Lấy danh mục từ DB (Laravel Query Builder)
        $categories = DB::table('categories')
            ->where('is_deleted', 0)
            ->orderBy('name')
            ->get();

        // Bạn có thể thêm tin tức từ DB nếu có
        return view('user.news', compact('categories'));
    }
}
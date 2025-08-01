<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Jewelry;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_deleted', 0)->limit(12)->get();
        $newProducts = Jewelry::with(['jewelryFiles.file'])
            ->where('is_deleted', 0)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // Add random discount/sold for demo (should be in DB ideally)
        foreach ($newProducts as $product) {
            $product->discount = rand(10, 30);
            $product->sold = rand(100, 500);
            // Lấy file đầu tiên nếu có
            $file = optional($product->jewelryFiles->first())->file;
            $product->path = $file ? $file->path : null;
        }

        return view('user.home', compact('categories', 'newProducts'));
    }
    public function detail($id)
    {
        $product =  Jewelry::with(['jewelryFiles.file'])
            ->where('id', $id)
            ->where('is_deleted', 0)
            ->firstOrFail();
        return view('user.product_detail', compact('product'));
    }
}

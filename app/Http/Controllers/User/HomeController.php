<?php

namespace App\Http\Controllers\User;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Jewelry;
use App\Models\JewelryFile;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Lấy categories với icon
        $categories = Category::with('file')
            ->where('is_deleted', 0)
            ->limit(12)
            ->get();
        foreach ($categories as $cat) {
            $cat->image = $cat->file ? ImageHelper::getImageUrl($cat->file->path) : null;
        }
        // Lấy sản phẩm mới với ảnh chính
        $newProducts = Jewelry::with(['category', 'jewelryFiles.file'])
            ->where('is_deleted', 0)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // Xử lý ảnh chính cho từng sản phẩm
        foreach ($newProducts as $product) {
            $img = ImageHelper::getMainImage($product);
            $product->image_path = $img; // used by current views
            $product->image = $img;      // alias for convenience


            // Thêm thông tin giả lập cho demo
            $product->discount = rand(10, 30);
            $product->sold = rand(100, 500);
        }

        // Lấy sản phẩm theo category nếu có filter
        $categoryId = $request->get('category');
        $filteredProducts = null;
        if ($categoryId) {
            $filteredProducts = Jewelry::with(['category', 'jewelryFiles.file'])
                ->where('category_id', $categoryId)
                ->where('is_deleted', 0)
                ->paginate(12);

            foreach ($filteredProducts as $product) {
                $mainFile = $product->jewelryFiles->where('is_main', 1)->first();
                $product->main_image = $mainFile && $mainFile->file ? $mainFile->file->path : null;
            }
        }

        return view('user.home', compact('categories', 'newProducts', 'filteredProducts'));
    }
}

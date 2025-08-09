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
    public function about()
{
    $products = [
        [
            "img" => "https://timevalue.vn/wp-content/uploads/2023/11/nhan-kim-cuong-nu-RTV29-1.jpg",
            "name" => "Nhẫn Kim Cương",
            "desc" => "Sang trọng và tinh tế."
        ],
        [
            "img" => "https://cdn.pnj.io/images/thumbnails/485/485/detailed/114/gl0000y001613-lac-tay-vang-24k-pnj-1.png",
            "name" => "Vòng Tay Vàng",
            "desc" => "Tinh xảo trong từng chi tiết."
        ],
        [
            "img" => "https://tse4.mm.bing.net/th/id/OIP.F_PuplSo_FSmkexToEiGoQHaHa?pid=Api&P=0&h=220",
            "name" => "Dây Chuyền Bạch Kim",
            "desc" => "Thể hiện đẳng cấp phái đẹp."
        ],
    ];

    return view('user.gioi_thieu', compact('products'));
}

}
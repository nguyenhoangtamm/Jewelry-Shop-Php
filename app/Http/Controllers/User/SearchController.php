<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jewelry;
use App\Models\Category;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('search');
        $categoryId = $request->input('category_id');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $sortBy = $request->input('sort_by', 'name'); // name, price_asc, price_desc, newest

        // Khởi tạo query builder
        $jewelryQuery = Jewelry::with(['category', 'jewelryFiles.file']);

        // Tìm kiếm theo tên sản phẩm
        if (!empty($query)) {
            $jewelryQuery->where('name', 'LIKE', '%' . $query . '%')
                ->orWhere('description', 'LIKE', '%' . $query . '%');
        }

        // Lọc theo danh mục
        if (!empty($categoryId)) {
            $jewelryQuery->where('category_id', $categoryId);
        }

        // Lọc theo khoảng giá
        if (!empty($minPrice)) {
            $jewelryQuery->where('price', '>=', $minPrice);
        }

        if (!empty($maxPrice)) {
            $jewelryQuery->where('price', '<=', $maxPrice);
        }

        // Sắp xếp
        switch ($sortBy) {
            case 'price_asc':
                $jewelryQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $jewelryQuery->orderBy('price', 'desc');
                break;
            case 'newest':
                $jewelryQuery->orderBy('created_at', 'desc');
                break;
            default:
                $jewelryQuery->orderBy('name', 'asc');
        }

        // Phân trang
        $jewelries = $jewelryQuery->paginate(12)->appends($request->all());

        // Lấy danh sách categories để hiển thị filter
        $categories = Category::all();

        // Đếm tổng số kết quả
        $totalResults = $jewelryQuery->count();

        return view('user.search', compact(
            'jewelries',
            'categories',
            'query',
            'categoryId',
            'minPrice',
            'maxPrice',
            'sortBy',
            'totalResults'
        ));
    }

    public function suggestions(Request $request)
    {
        $query = $request->input('q');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $suggestions = Jewelry::where('name', 'LIKE', '%' . $query . '%')
            ->select('id', 'name', 'price')
            ->with(['jewelryFiles:jewelry_id,file_id', 'jewelryFiles.file:id,path'])
            ->limit(8)
            ->get()
            ->map(function ($jewelry) {
                $imageUrl = $jewelry->jewelryFiles->isNotEmpty() && $jewelry->jewelryFiles->first()->file
                    ? \App\Helpers\ImageHelper::getImageUrl($jewelry->jewelryFiles->first()->file->path)
                    : asset('img/no-image.png');

                return [
                    'id' => $jewelry->id,
                    'name' => $jewelry->name,
                    'price' => number_format($jewelry->price, 0, ',', '.') . ' ₫',
                    'image' => $imageUrl,
                    'url' => "/detail/{$jewelry->id}"
                ];
            });

        return response()->json($suggestions);
    }
}

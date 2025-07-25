<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jewelry;
use App\Models\Category;
use App\Models\File;
use App\Models\JewelryFile;
use App\Models\Review;
use App\Models\User;

class ProductDetailController extends Controller
{
    public function show($id)
    {
        $jewelry = Jewelry::find($id);
        if (!$jewelry) {
            abort(404, 'Không tìm thấy sản phẩm.');
        }
        $images = [];
        foreach ($jewelry->jewelryFiles as $jewelryFile) {
            $file = $jewelryFile->file;
            if ($file) {
                $images[] = $file->path;
            }
        }
    
        // Thống kê đánh giá
        $reviews = $jewelry->reviews->where('is_deleted', 0)->sortByDesc('created_at');
        $totalReviews = $reviews->count();
        $totalRating = $reviews->sum('rating');
        $ratingCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        foreach ($reviews as $review) {
            $ratingCounts[$review->rating]++;
        }
        $averageRating = $totalReviews > 0 ? round($totalRating / $totalReviews, 1) : 0;
        return view('user.product_detail', [
            'jewelry' => $jewelry,
            'images' => $images,
            'reviews' => $reviews,
            'totalReviews' => $totalReviews,
            'averageRating' => $averageRating,
            'ratingCounts' => $ratingCounts,
        ]);
    }
}

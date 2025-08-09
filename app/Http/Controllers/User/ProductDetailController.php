<?php

namespace App\Http\Controllers\User;

use App\Helpers\ImageHelper;
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
        $main_image = null;
        foreach ($jewelry->jewelryFiles as $jewelryFile) {
            if ($jewelryFile->file) {
                $imageData = [
                    'id' => $jewelryFile->file->id,
                    'path' => ImageHelper::getImageUrl($jewelryFile->file->path),
                    'is_main' => $jewelryFile->is_main,
                ];
                $images[] = $imageData;
                if ($jewelryFile->is_main && $main_image === null) {
                    $main_image = $imageData;
                }
            }
        }
        // Nếu không có ảnh chính, lấy ảnh đầu tiên nếu có
        if ($main_image === null && count($images) > 0) {
            $main_image = $images[0];
        }
        // Đảm bảo main_image là phần tử đầu tiên trong danh sách images
        if ($main_image !== null && (count($images) === 0 || $images[0]['id'] !== $main_image['id'])) {
            // Xóa main_image khỏi vị trí cũ nếu đã có trong images
            $images = array_filter($images, function ($img) use ($main_image) {
                return $img['id'] !== $main_image['id'];
            });
            // Chèn main_image vào đầu danh sách
            array_unshift($images, $main_image);
            // Đảm bảo chỉ số lại cho mảng
            $images = array_values($images);
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
            'main_image' => $main_image,
            'reviews' => $reviews,
            'totalReviews' => $totalReviews,
            'averageRating' => $averageRating,
            'ratingCounts' => $ratingCounts,
        ]);
    }
}

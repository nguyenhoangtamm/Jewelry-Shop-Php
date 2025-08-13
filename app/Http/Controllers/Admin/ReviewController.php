<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Jewelry;
use App\Helpers\ImageHelper;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Hiển thị tất cả đánh giá
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $jewelry_id = $request->input('jewelry_id');
        $rating = $request->input('rating');

        $query = Review::withDeleted()
            ->with(['user', 'jewelry.jewelryFiles.file'])
            ->orderBy('created_at', 'desc');

        // Tìm kiếm theo nội dung
        if ($search) {
            $query->where('content', 'like', "%$search%");
        }

        // Lọc theo sản phẩm
        if ($jewelry_id) {
            $query->where('jewelries_id', $jewelry_id);
        }

        // Lọc theo rating
        if ($rating) {
            $query->where('rating', $rating);
        }

        $reviews = $query->paginate(15);

        // Thêm thuộc tính image cho mỗi review
        foreach ($reviews as $review) {
            if ($review->jewelry) {
                $review->setAttribute('image', ImageHelper::getMainImage($review->jewelry));
            } else {
                $review->setAttribute('image', asset('img/no-image.png')); // ảnh mặc định nếu không có
            }
        }

        // Lấy danh sách sản phẩm cho dropdown filter
        $jewelries = Jewelry::select('id', 'name')->orderBy('name')->get();

        return view('admin.reviews.index', compact('reviews', 'jewelries', 'search', 'jewelry_id', 'rating'));
    }

    /**
     * Hiển thị đánh giá theo sản phẩm cụ thể
     */
    public function showByProduct($jewelry_id, Request $request)
    {
        $jewelry = Jewelry::with(['jewelryFiles.file'])->findOrFail($jewelry_id);
        $jewelry->setAttribute('image', ImageHelper::getMainImage($jewelry));
        $search = $request->input('search');
        $rating = $request->input('rating');

        $query = Review::withDeleted()
            ->with(['user'])
            ->where('jewelries_id', $jewelry_id)
            ->orderBy('created_at', 'desc');

        // Tìm kiếm theo nội dung
        if ($search) {
            $query->where('content', 'like', "%$search%");
        }

        // Lọc theo rating
        if ($rating) {
            $query->where('rating', $rating);
        }

        $reviews = $query->paginate(15);

        // Thêm thuộc tính image cho mỗi review
        foreach ($reviews as $review) {
            if ($review->jewelry) {
                $review->setAttribute('image', ImageHelper::getMainImage($review->jewelry));
            } else {
                $review->setAttribute('image', asset('img/no-image.png')); // ảnh mặc định nếu không có
            }
        }

        // Thống kê đánh giá
        $reviewStats = $this->getReviewStats($jewelry_id);

        return view('admin.reviews.by-product', compact('reviews', 'jewelry', 'search', 'rating', 'reviewStats'));
    }

    /**
     * Hiển thị chi tiết đánh giá
     */
    public function show($id)
    {
        $review = Review::withDeleted()
            ->with(['user', 'jewelry.jewelryFiles.file'])
            ->findOrFail($id);

        // Thêm thuộc tính image cho review
        if ($review->jewelry) {
            $review->setAttribute('image', ImageHelper::getMainImage($review->jewelry));
        } else {
            $review->setAttribute('image', asset('img/no-image.png')); // ảnh mặc định nếu không có
        }

        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Xóa đánh giá (soft delete)
     */
    public function destroy($id)
    {
        $review = Review::withDeleted()->findOrFail($id);

        if (!$review->is_deleted) {
            $review->update(['is_deleted' => true]);
            return back()->with('success', 'Đánh giá đã được xóa thành công.');
        }

        return back()->with('error', 'Đánh giá này đã được xóa trước đó.');
    }

    /**
     * Khôi phục đánh giá đã xóa
     */
    public function restore($id)
    {
        $review = Review::withDeleted()->findOrFail($id);

        if ($review->is_deleted) {
            $review->update(['is_deleted' => false]);
            return back()->with('success', 'Đánh giá đã được khôi phục thành công.');
        }

        return back()->with('error', 'Đánh giá này chưa bị xóa.');
    }

    /**
     * Xóa vĩnh viễn đánh giá
     */
    public function forceDelete($id)
    {
        $review = Review::withDeleted()->findOrFail($id);
        $review->forceDelete();

        return back()->with('success', 'Đánh giá đã được xóa vĩnh viễn.');
    }

    /**
     * Lấy thống kê đánh giá cho sản phẩm
     */
    private function getReviewStats($jewelry_id)
    {
        $stats = Review::where('jewelries_id', $jewelry_id)
            ->selectRaw('
                COUNT(*) as total_reviews,
                AVG(rating) as average_rating,
                SUM(CASE WHEN rating = 5 THEN 1 ELSE 0 END) as five_star,
                SUM(CASE WHEN rating = 4 THEN 1 ELSE 0 END) as four_star,
                SUM(CASE WHEN rating = 3 THEN 1 ELSE 0 END) as three_star,
                SUM(CASE WHEN rating = 2 THEN 1 ELSE 0 END) as two_star,
                SUM(CASE WHEN rating = 1 THEN 1 ELSE 0 END) as one_star
            ')
            ->first();

        return $stats;
    }
}

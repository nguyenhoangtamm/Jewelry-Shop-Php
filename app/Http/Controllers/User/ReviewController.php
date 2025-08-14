<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Jewelry;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    public function getReviews($jewelry_id, Request $request)
    {
        try {
            $jewelry = Jewelry::findOrFail($jewelry_id);

            $query = Review::with('user')
                ->where('jewelries_id', $jewelry_id)
                ->where('is_deleted', 0)
                ->orderBy('created_at', 'desc');

            // Filter by rating if specified
            if ($request->has('rating') && $request->rating !== 'all') {
                $query->where('rating', $request->rating);
            }

            $reviews = $query->get();

            $reviewsData = $reviews->map(function ($review) {
                $user = $review->user;
                $userAvatar = null;

                // Lấy avatar của user nếu có
                if ($user && $user->avatar) {
                    $userAvatar = \App\Helpers\ImageHelper::getImageUrl($user->avatar);
                }

                return [
                    'id' => $review->id,
                    'rating' => $review->rating,
                    'content' => $review->content,
                    'user_name' => $user ? $user->fullname : 'Người dùng ẩn danh',
                    'user_avatar' => $userAvatar,
                    'created_at' => $review->created_at ? $review->created_at->toISOString() : '',
                ];
            });

            return response()->json([
                'success' => true,
                'reviews' => $reviewsData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi khi tải đánh giá'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            // Check if user is authenticated
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn cần đăng nhập để đánh giá sản phẩm'
                ], 401);
            }

            $validator = Validator::make($request->all(), [
                'jewelry_id' => 'required|exists:jewelries,id',
                'rating' => 'required|integer|min:1|max:5',
                'content' => 'required|string|min:10|max:1000'
            ], [
                'jewelry_id.required' => 'Thiếu thông tin sản phẩm',
                'jewelry_id.exists' => 'Sản phẩm không tồn tại',
                'rating.required' => 'Vui lòng chọn số sao đánh giá',
                'rating.integer' => 'Đánh giá phải là số nguyên',
                'rating.min' => 'Đánh giá phải từ 1 đến 5 sao',
                'rating.max' => 'Đánh giá phải từ 1 đến 5 sao',
                'content.required' => 'Vui lòng nhập nội dung đánh giá',
                'content.min' => 'Nội dung đánh giá phải có ít nhất 10 ký tự',
                'content.max' => 'Nội dung đánh giá không được vượt quá 1000 ký tự'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = Auth::user();
            $jewelry_id = $request->jewelry_id;

            // Check if user has already reviewed this product
            $existingReview = Review::where('user_id', $user->id)
                ->where('jewelries_id', $jewelry_id)
                ->where('is_deleted', 0)
                ->first();

            if ($existingReview) {
                return response()->json([
                    'success' => false,
                    'message' => 'Bạn đã đánh giá sản phẩm này rồi'
                ], 400);
            }

            // Create new review
            $review = Review::create([
                'user_id' => $user->id,
                'jewelries_id' => $jewelry_id,
                'rating' => $request->rating,
                'content' => $request->content,
                'is_deleted' => 0
            ]);

            // Calculate new summary
            $summary = $this->calculateReviewSummary($jewelry_id);

            return response()->json([
                'success' => true,
                'message' => 'Đánh giá của bạn đã được gửi thành công!',
                'review' => [
                    'id' => $review->id,
                    'rating' => $review->rating,
                    'content' => $review->content,
                    'user_name' => $user->name,
                    'created_at' => $review->created_at->toISOString(),
                ],
                'summary' => $summary
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi gửi đánh giá'
            ], 500);
        }
    }

    private function calculateReviewSummary($jewelry_id)
    {
        $reviews = Review::where('jewelries_id', $jewelry_id)
            ->where('is_deleted', 0)
            ->get();

        $totalReviews = $reviews->count();
        $totalRating = $reviews->sum('rating');

        $ratingCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
        foreach ($reviews as $review) {
            $ratingCounts[$review->rating]++;
        }

        $averageRating = $totalReviews > 0 ? round($totalRating / $totalReviews, 1) : 0;

        return [
            'totalReviews' => $totalReviews,
            'averageRating' => $averageRating,
            'ratingCounts' => $ratingCounts
        ];
    }
}

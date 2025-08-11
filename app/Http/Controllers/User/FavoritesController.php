<?php

namespace App\Http\Controllers\User;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class FavoritesController extends Controller
{
    public function remove($id)
    {
        $userId = Auth::id();
        $favorite = Favorite::where('id', $id)->where('user_id', $userId)->first();
        if (!$favorite) {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm yêu thích.');
        }
        $favorite->delete();
        return redirect()->back()->with('success', 'Đã xóa khỏi danh sách yêu thích.');
    }
    public function index(Request $request)
    {
        $userId = Auth::id();
        $favorites = Favorite::where('user_id', $userId)->with('jewelry')->get();
        foreach ($favorites as $favorite) {
            $favorite->main_image = ImageHelper::getMainImage($favorite->jewelry);
        }
        return view('user.favorites.index', compact('favorites'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'jewelry_id' => 'required|integer|exists:jewelries,id',
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        $favorite = Favorite::firstOrCreate([
            'user_id' => $userId,
            'jewelry_id' => $request->integer('jewelry_id'),
        ]);

        return response()->json([
            'message' => 'Đã thêm vào danh sách yêu thích',
            'favorited' => true,
            'favorite_id' => $favorite->id,
        ]);
    }
}

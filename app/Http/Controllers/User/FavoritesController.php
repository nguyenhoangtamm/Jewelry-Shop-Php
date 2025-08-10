<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class FavoritesController extends Controller
{
    public function index(Request $request)
    {
        // Placeholder: render a simple favorites page
        return view('user.favorites.index');
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

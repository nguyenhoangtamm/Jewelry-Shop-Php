<?php

namespace App\Http\Controllers\User;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jewelry;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $jewelry_id = $request->query('jewelry');
        $quantity = max(1, (int) $request->query('quantity', 1));

        if (!$jewelry_id || !is_numeric($jewelry_id)) {
            return redirect()->route('home');
        }

        $jewelry = Jewelry::with('category')->find($jewelry_id);
        if (!$jewelry) {
            return redirect()->route('home');
        }

        $image = ImageHelper::getMainImage($jewelry);
        $total_amount = $jewelry->price * $quantity;
        $user = Auth::user();

        return view('user.checkout', compact('jewelry', 'image', 'quantity', 'total_amount', 'user', 'jewelry_id'));
    }
}

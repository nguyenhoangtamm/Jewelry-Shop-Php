<?php

namespace App\Http\Controllers\User;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Jewelry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Hiển thị giỏ hàng
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $cartItems = Cart::getUserCart(Auth::id());
        $total = Cart::getCartTotal(Auth::id());
        foreach ($cartItems as $item) {
            $item->main_image = ImageHelper::getMainImage($item->jewelry);
        }

        return view('user.cart.index', compact('cartItems', 'total'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function add(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng'
            ]);
        }

        $request->validate([
            'jewelry_id' => 'required|exists:jewelries,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $jewelry = Jewelry::find($request->jewelry_id);
        if (!$jewelry) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại'
            ]);
        }

        $cartItem = Cart::addItem(
            Auth::id(),
            $request->jewelry_id,
            $request->quantity
        );

        if ($cartItem) {
            $cartCount = Cart::getCartCount(Auth::id());
            return response()->json([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào giỏ hàng',
                'cartCount' => $cartCount
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra khi thêm sản phẩm'
        ]);
    }

    /**
     * Cập nhật số lượng sản phẩm trong giỏ hàng
     */
    public function update(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập'
            ]);
        }

        $request->validate([
            'jewelry_id' => 'required|exists:jewelries,id',
            'quantity' => 'required|integer|min:0'
        ]);

        $result = Cart::updateQuantity(
            Auth::id(),
            $request->jewelry_id,
            $request->quantity
        );

        if ($result !== false) {
            $cartCount = Cart::getCartCount(Auth::id());
            $cartTotal = Cart::getCartTotal(Auth::id());

            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật giỏ hàng',
                'cartCount' => $cartCount,
                'cartTotal' => number_format($cartTotal, 0, ',', '.') . ' VNĐ'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra khi cập nhật giỏ hàng'
        ]);
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function remove(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập'
            ]);
        }

        $request->validate([
            'jewelry_id' => 'required|exists:jewelries,id'
        ]);

        $removed = Cart::removeItem(Auth::id(), $request->jewelry_id);

        if ($removed) {
            $cartCount = Cart::getCartCount(Auth::id());
            $cartTotal = Cart::getCartTotal(Auth::id());

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng',
                'cartCount' => $cartCount,
                'cartTotal' => number_format($cartTotal, 0, ',', '.') . ' VNĐ'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra khi xóa sản phẩm'
        ]);
    }

    /**
     * Xóa toàn bộ giỏ hàng
     */
    public function clear()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập'
            ]);
        }

        $cleared = Cart::clearCart(Auth::id());

        if ($cleared) {
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa toàn bộ giỏ hàng',
                'cartCount' => 0,
                'cartTotal' => '0 VNĐ'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Có lỗi xảy ra khi xóa giỏ hàng'
        ]);
    }

    /**
     * Lấy số lượng sản phẩm trong giỏ hàng (cho AJAX)
     */
    public function getCartCount()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $count = Cart::getCartCount(Auth::id());
        return response()->json(['count' => $count]);
    }

    /**
     * Lấy thông tin giỏ hàng chi tiết (cho AJAX)
     */
    public function getCartData()
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập'
            ]);
        }

        $items = [];
        $total = 0;
        $cartItems = Cart::with('jewelry')->where('user_id', Auth::id())->get();
        $count = $cartItems->count();
        foreach ($cartItems as $item) {
            $jewelry = $item->jewelry;
            $img = $jewelry ? ImageHelper::getMainImage($jewelry) : asset('images/no-image.jpg');
            $items[] = [
                'id' => $item->jewelry_id,
                'name' => $jewelry ? $jewelry->name : 'Sản phẩm',
                'price' => $item->price,
                'quantity' => $item->quantity,
                'image' => $img,
                'formatted_price' => number_format($item->price, 0, ',', '.') . ' VNĐ',
                'item_total' => number_format($item->price * $item->quantity, 0, ',', '.') . ' VNĐ'
            ];
            $total += $item->price * $item->quantity;
        }
        return response()->json([
            'success' => true,
            'items' => $items,
            'total' => $total,
            'count' => $count,
            'formattedTotal' => number_format($total, 0, ',', '.') . ' VNĐ'
        ]);
    }
}

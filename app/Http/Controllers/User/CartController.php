<?php

namespace App\Http\Controllers\User;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Jewelry;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $request->validate([
            'jewelry_id' => 'required|exists:jewelries,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $jewelry = Jewelry::findOrFail($request->jewelry_id);

        // Kiểm tra số lượng tồn kho
        if ($request->quantity > $jewelry->stock) {
            return response()->json([
                'success' => false,
                'message' => 'Số lượng yêu cầu vượt quá tồn kho hiện có!'
            ]);
        }

        // Lấy giỏ hàng từ session
        $cart = Session::get('cart', []);

        $jewelryId = $request->jewelry_id;
        $quantity = $request->quantity;

        // Nếu sản phẩm đã có trong giỏ hàng
        if (isset($cart[$jewelryId])) {
            $newQuantity = $cart[$jewelryId]['quantity'] + $quantity;

            // Kiểm tra tổng số lượng không vượt quá tồn kho
            if ($newQuantity > $jewelry->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tổng số lượng trong giỏ hàng sẽ vượt quá tồn kho!'
                ]);
            }

            $cart[$jewelryId]['quantity'] = $newQuantity;
        } else {
            // Thêm sản phẩm mới vào giỏ hàng
            $cart[$jewelryId] = [
                'id' => $jewelry->id,
                'name' => $jewelry->name,
                'price' => $jewelry->price,
                'quantity' => $quantity,
                'image' => $this->getJewelryImage($jewelry)
            ];
        }

        // Lưu giỏ hàng vào session
        Session::put('cart', $cart);

        // Tính tổng số lượng và tổng tiền
        $cartInfo = $this->getCartInfo();

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm sản phẩm vào giỏ hàng!',
            'cart_count' => $cartInfo['total_items'],
            'cart_total' => number_format($cartInfo['total_amount'], 0, ',', '.') . ' VNĐ'
        ]);
    }

    public function show()
    {
        $cart = Session::get('cart', []);
        $cartInfo = $this->getCartInfo();
        foreach ($cart as $key => $item) {
            $jewelry = Jewelry::find($item['id']);
            $img = $jewelry ? ImageHelper::getMainImage($jewelry) : asset('images/no-image.jpg');
            $cart[$key]['image'] = $img;
        }
        return view('user.cart', [
            'cart' => $cart,
            'total_items' => $cartInfo['total_items'],
            'total_amount' => $cartInfo['total_amount']
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'jewelry_id' => 'required|exists:jewelries,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $cart = Session::get('cart', []);
        $jewelryId = $request->jewelry_id;

        if (isset($cart[$jewelryId])) {
            $jewelry = Jewelry::findOrFail($jewelryId);

            if ($request->quantity > $jewelry->stock) {
                return response()->json([
                    'success' => false,
                    'message' => 'Số lượng vượt quá tồn kho!'
                ]);
            }

            $cart[$jewelryId]['quantity'] = $request->quantity;
            Session::put('cart', $cart);

            $cartInfo = $this->getCartInfo();

            return response()->json([
                'success' => true,
                'cart_count' => $cartInfo['total_items'],
                'cart_total' => number_format($cartInfo['total_amount'], 0, ',', '.') . ' VNĐ',
                'item_total' => number_format($cart[$jewelryId]['price'] * $cart[$jewelryId]['quantity'], 0, ',', '.') . ' VNĐ'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Sản phẩm không tồn tại trong giỏ hàng!'
        ]);
    }

    public function remove(Request $request)
    {
        // Thêm validation
        $request->validate([
            'jewelry_id' => 'required|integer'
        ]);

        $jewelryId = $request->jewelry_id;
        $cart = Session::get('cart', []);

        if (isset($cart[$jewelryId])) {
            unset($cart[$jewelryId]);
            Session::put('cart', $cart);

            $cartInfo = $this->getCartInfo();

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng!',
                'cart_count' => $cartInfo['total_items'],
                'cart_total' => number_format($cartInfo['total_amount'], 0, ',', '.') . ' VNĐ'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Sản phẩm không tồn tại trong giỏ hàng!'
        ]);
    }

    public function clear()
    {
        Session::forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa tất cả sản phẩm khỏi giỏ hàng!',
            'cart_count' => 0,
            'cart_total' => '0 VNĐ'
        ]);
    }

    public function getCartCount()
    {
        $cartInfo = $this->getCartInfo();

        return response()->json([
            'cart_count' => $cartInfo['total_items']
        ]);
    }

    public function getCartData()
    {
        $cartInfo = $this->getCartInfo();
        
        return response()->json([
            'success' => true,
            'cart_count' => $cartInfo['total_items'],
            'cart_total' => number_format($cartInfo['total_amount'], 0, ',', '.') . ' VNĐ',
            'cart_items' => $this->getCartItemsForDropdown()
        ]);
    }
    
    private function getCartInfo()
    {
        $cart = Session::get('cart', []);
        $totalItems = 0;
        $totalAmount = 0;

        foreach ($cart as $item) {
            $totalItems += $item['quantity'];
            $totalAmount += $item['price'] * $item['quantity'];
        }

        return [
            'total_items' => $totalItems,
            'total_amount' => $totalAmount
        ];
    }

    // Thêm method mới để format dữ liệu cho dropdown
    private function getCartItemsForDropdown()
    {
        $cart = Session::get('cart', []);
        $items = [];
        
        foreach ($cart as $item) {
            $items[] = [
                'id' => $item['id'],
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'image' => $item['image'],
                'formatted_price' => number_format($item['price'], 0, ',', '.') . ' VNĐ',
                'item_total' => number_format($item['price'] * $item['quantity'], 0, ',', '.') . ' VNĐ'
            ];
        }
        
        return $items;
    }
    
    private function getJewelryImage($jewelry)
    {
        $jewelryFile = $jewelry->jewelryFiles()->with('file')->first();

        if ($jewelryFile && $jewelryFile->file && $jewelryFile->file->is_deleted == 0) {
            return asset(ltrim($jewelryFile->file->path, '/'));
        }

        return asset('images/no-image.jpg'); // Ảnh mặc định
    }
}
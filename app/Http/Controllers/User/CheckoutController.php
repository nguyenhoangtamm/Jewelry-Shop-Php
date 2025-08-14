<?php

namespace App\Http\Controllers\User;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jewelry;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Hiển thị trang checkout từ cart
     */
    public function index(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    $selectedItems = $request->query('selected_items');

    if ($selectedItems) {
        $selectedIds = explode(',', $selectedItems);
        $cartItems = Cart::getUserCart(Auth::id())
            ->whereIn('jewelry_id', $selectedIds);
        $total = $cartItems->sum('price');
    } else {
        $cartItems = Cart::getUserCart(Auth::id());
        $total = Cart::getCartTotal(Auth::id());
    }

    if ($cartItems->isEmpty()) {
        return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống');
    }

    return view('user.checkout.index', compact('cartItems', 'total'));
}


    /**
     * Xử lý thanh toán từ giỏ hàng
     */
    public function store(Request $request)
    {
        if (!Auth::check()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Vui lòng đăng nhập để đặt hàng!',
                    'redirect' => route('login'),
                ], 401);
            }
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đặt hàng!');
        }

        $rules = [
            'fullname' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string|max:500',
            'note' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:cod,bank_transfer'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dữ liệu không hợp lệ',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();
        $cartItems = Cart::getUserCart($user->id);

        if ($cartItems->isEmpty()) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Giỏ hàng của bạn đang trống'
                ]);
            }
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn đang trống');
        }

        $totalAmount = Cart::getCartTotal($user->id);

        DB::beginTransaction();
        try {
            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'status' => 'chờ xử lý',
                'notes' => $this->formatCheckoutNotes($request),
            ]);

            // Tạo chi tiết đơn hàng
            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'jewelry_id' => $item->jewelry_id,
                    'quantity' => $item->quantity,
                    'unit_price' => $item->price,
                ]);

                // Giảm số lượng tồn kho (nếu có field stock)
                $jewelry = Jewelry::find($item->jewelry_id);
                if ($jewelry && isset($jewelry->stock)) {
                    $jewelry->stock = max(0, $jewelry->stock - $item->quantity);
                    $jewelry->save();
                }
            }

            // Xóa toàn bộ giỏ hàng sau khi đặt hàng thành công
            Cart::clearCart($user->id);

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đặt hàng thành công! Cảm ơn bạn đã mua sắm tại cửa hàng.',
                    'order_id' => $order->id,
                    'redirect' => route('home')
                ]);
            }

            return redirect()->route('home')->with('success', 'Đặt hàng thành công! Cảm ơn bạn đã mua sắm tại cửa hàng.');
        } catch (\Exception $e) {
            DB::rollback();

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại.'
                ], 500);
            }

            return back()->with('error', 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại.')->withInput();
        }
    }

    /**
     * Hiển thị trang checkout cho sản phẩm đơn lẻ (mua ngay)
     */
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

    private function formatCheckoutNotes($request)
    {
        $notes = [];
        $notes[] = "Họ tên: " . $request->fullname;
        $notes[] = "SĐT: " . $request->phone;
        if ($request->email) {
            $notes[] = "Email: " . $request->email;
        }
        $notes[] = "Địa chỉ: " . $request->address;
        $notes[] = "Thanh toán: " . $this->getPaymentMethodText($request->payment_method);

        if ($request->note) {
            $notes[] = "Ghi chú: " . $request->note;
        }

        return implode("\n", $notes);
    }

    private function formatOrderNotes($request)
    {
        $notes = [];
        $notes[] = "Họ tên: " . $request->fullname;
        $notes[] = "SĐT: " . $request->phone_number;
        if ($request->email) {
            $notes[] = "Email: " . $request->email;
        }
        $notes[] = "Địa chỉ: " . $request->address;
        $notes[] = "Vận chuyển: " . ($request->shipping_method === 'express' ? 'Giao hàng nhanh' : 'Giao hàng tiêu chuẩn');
        $notes[] = "Thanh toán: " . $this->getPaymentMethodText($request->payment_method);

        if ($request->note) {
            $notes[] = "Ghi chú: " . $request->note;
        }

        return implode("\n", $notes);
    }

    private function getPaymentMethodText($method)
    {
        switch ($method) {
            case 'cod':
                return 'Thanh toán khi nhận hàng (COD)';
            case 'bank_transfer':
                return 'Chuyển khoản ngân hàng';
            case 'cash':
                return 'Thanh toán tiền mặt';
            default:
                return 'Không xác định';
        }
    }

    private function removeFromCart($jewelryId)
    {
        $cart = Session::get('cart', []);
        if (isset($cart[$jewelryId])) {
            unset($cart[$jewelryId]);
            Session::put('cart', $cart);
        }
    }
}

<?php

namespace App\Http\Controllers\User;

use App\Helpers\ImageHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jewelry;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
    public function store(Request $request)
    {
        // Kiểm tra đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đặt hàng!');
        }

        $request->validate([
            'jewelry_id' => 'required|exists:jewelries,id',
            'quantity' => 'required|integer|min:1',
            'fullname' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string|max:500',
            'shipping_method' => 'required|in:standard,express',
            'payment_method' => 'required|in:cod,bank_transfer,cash',
            'note' => 'nullable|string|max:1000',
            'total_amount' => 'required|numeric|min:0'
        ]);

        try {
            $jewelry = Jewelry::findOrFail($request->jewelry_id);

            // Kiểm tra tồn kho
            if ($request->quantity > $jewelry->stock) {
                return back()->with('error', 'Số lượng sản phẩm không đủ trong kho!');
            }

            // Tính toán tổng tiền (bao gồm phí vận chuyển)
            $subtotal = $jewelry->price * $request->quantity;
            $shippingFee = $request->shipping_method === 'express' ? 50000 : 0;
            $totalAmount = $subtotal + $shippingFee;

            // Kiểm tra tổng tiền từ form có khớp không
            if (abs($totalAmount - $request->total_amount) > 1) {
                return back()->with('error', 'Có lỗi trong tính toán giá tiền!');
            }

            // Tạo đơn hàng
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'notes' => $this->formatOrderNotes($request),
            ]);

            // Tạo chi tiết đơn hàng
            OrderDetail::create([
                'order_id' => $order->id,
                'jewelry_id' => $request->jewelry_id,
                'quantity' => $request->quantity,
                'unit_price' => $jewelry->price,
            ]);

            // Giảm tồn kho
            $jewelry->decrement('stock', $request->quantity);

            // Xóa sản phẩm khỏi giỏ hàng (nếu có)
            $this->removeFromCart($request->jewelry_id);

            return redirect()->route('user.orders.show', $order->id)->with('success', 'Đặt hàng thành công! Mã đơn hàng: #' . $order->id);
        } catch (\Exception $e) {
            return back()->with('error', 'Có lỗi xảy ra khi đặt hàng. Vui lòng thử lại!');
        }
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

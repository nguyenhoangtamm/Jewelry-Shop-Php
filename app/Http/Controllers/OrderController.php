<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
   public function index(Request $request)
{
    $orders = Order::with(['user', 'orderDetails'])
        ->where('is_deleted', 0)
        ->where('status', 'hoàn thành') // chỉ lấy đơn đã hoàn thành
        ->paginate(5);

    // Tính tổng tiền nếu cần
    foreach ($orders as $order) {
        $order->computed_total = $order->orderDetails->sum(function ($detail) {
            $price = $detail->unit_price ?? $detail->price ?? 0;
            return ($detail->quantity ?? 0) * $price;
        });
    }

    return view('admin.orders.index', compact('orders'));
}


    public function approveForm($id)
    {
        $order = Order::with(['user', 'orderDetails.jewelry'])->findOrFail($id);
        return view('admin.orders.approve', compact('order'));
    }

    public function approve(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 'hoàn thành';
        $order->save();

        return redirect()->route('admin.orders.index')->with('success', 'Duyệt đơn hàng thành công!');
    }

public function pending()
{
    // Lấy orders cùng user và orderDetails để không phát sinh N+1 query
    $orders = Order::with(['user', 'orderDetails'])->where('status', 'chờ xử lý')->paginate(10);

    // Tính computed_total cho từng order dựa trên orderDetails
    foreach ($orders as $order) {
        $order->computed_total = $order->orderDetails->sum(function ($detail) {
            // Một số project đặt tên cột giá khác nhau (price, unit_price, don_gia, etc.)
            // Thử lấy theo thứ tự ưu tiên; nếu không có thì xem như 0.
            $price = $detail->price ?? $detail->unit_price ?? $detail->don_gia ?? $detail->gia ?? 0;
            $quantity = $detail->quantity ?? 0;
            return $quantity * $price;
        });
    }

    return view('admin.orders.pending', compact('orders'));
}


public function destroy($id)
{
    $order = Order::findOrFail($id);
    $order->delete();

    return response()->json(['message' => 'Xóa đơn hàng thành công']);
}

  public function show($id)
{
    $order = Order::with(['user', 'orderDetails.jewelry'])->findOrFail($id);
    return view('admin.orders.show', compact('order'));
}

}
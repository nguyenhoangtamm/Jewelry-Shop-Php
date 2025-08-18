<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::with(['user', 'orderDetails'])
            ->where('is_deleted', 0)
            ->where('status', 'hoàn thành') // chỉ lấy đơn đã hoàn thành
            ->orderBy('created_at', 'desc')
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

        $page = $request->input('page');
        $redirect = redirect()->route('admin.orders.pending');
        if ($page) {
            $redirect = redirect()->route('admin.orders.pending', ['page' => $page]);
        }
        return $redirect->with('success', 'Duyệt đơn hàng thành công!');
    }
public function pending(Request $request)
{
    $query = Order::with(['user', 'orderDetails'])
        ->where('status', 'chờ xử lý')
        ->where('is_deleted', 0); // tránh lấy đơn bị xóa mềm nếu có cột này

    // --- Lọc theo thời gian ---
    $filter = $request->input('filter');
    if ($filter === 'today') {
        $query->whereDate('created_at', today());
    } elseif ($filter === 'week') {
        $query->whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    } elseif ($filter === 'month') {
        $query->whereMonth('created_at', now()->month)
              ->whereYear('created_at', now()->year);
    }


// --- Tìm kiếm ---
if ($search = $request->input('search')) {
    $query->where(function ($q) use ($search) {
        $q->where('id', 'like', "%$search%") // tìm theo mã đơn
          ->orWhereHas('user', function ($sub) use ($search) {
              $sub->where('username', 'like', "%$search%")
                  ->orWhere('fullname', 'like', "%$search%")   // ✅ tìm theo tên khách hàng
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('phone_number', 'like', "%$search%")
                  ->orWhere('address', 'like', "%$search%");
              
              // Nếu search là ngày hợp lệ thì so với ngày sinh
              if (strtotime($search)) {
                  $sub->orWhereDate('date_of_birth', $search);
              }
          });
    });
}


    // --- Phân trang ---
    $orders = $query->orderBy('created_at', 'desc')->paginate(10);

    // --- Tính computed_total ---
    foreach ($orders as $order) {
        $order->computed_total = $order->orderDetails->sum(function ($detail) {
            $price = $detail->price ?? $detail->unit_price ?? $detail->don_gia ?? $detail->gia ?? 0;
            $quantity = $detail->quantity ?? 0;
            return $quantity * $price;
        });
    }

    return view('admin.orders.pending', compact('orders'));
}


    public function destroy(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->softDelete();

        return response()->json(['message' => 'Xóa đơn hàng thành công']);
    }

    public function show($id)
    {
        $order = Order::with(['user', 'orderDetails.jewelry'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
    public function cancel($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'chờ xử lý')
            ->firstOrFail();

        $order->status = 'cancelled';
        $order->save();

        return redirect()->route('user.orders.index')
            ->with('success', 'Đơn hàng đã được hủy thành công.');
    }
    public function bulkApprove(Request $request)
    {
        $orderIds = $request->input('order_ids', []);

        if (empty($orderIds)) {
            return response()->json([
                'success' => false,
                'error' => 'Không có đơn hàng nào được chọn.'
            ], 400);
        }

        $count = Order::whereIn('id', $orderIds)->update(['status' => 'hoàn thành']);

        return response()->json([
            'success' => true,
            'message' => 'Đã duyệt ' . $count . ' đơn hàng.'
        ]);
    }
}
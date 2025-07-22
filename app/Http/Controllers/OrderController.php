<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->where('is_deleted', 0);
        $orders = $query->paginate(5);
        return view('admin.orders.index', compact('orders'));
    }
    // Thêm các hàm show, update, destroy nếu cần
}

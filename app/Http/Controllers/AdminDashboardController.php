<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // Tổng thu nhập
        $income = Order::where('status', 'Complete')
            ->with(['orderDetails.jewelry'])
            ->get()
            ->flatMap(function ($order) {
                return $order->orderDetails->map(function ($detail) {
                    return $detail->quantity * $detail->jewelry->price;
                });
            })->sum();

        // Tổng số khách hàng
        $count_customer = User::count();

        // Tổng số đơn hàng
        $count_order = Order::count();

        // Dữ liệu biểu đồ thu nhập theo tháng năm hiện tại
        $year = $request->input('year', date('Y'));
        $monthly_income = Order::where('status', 'Complete')
            ->whereYear('created_at', $year)
            ->with(['orderDetails.jewelry'])
            ->get()
            ->groupBy(function ($order) {
                return $order->created_at->format('m');
            })
            ->map(function ($orders) {
                return $orders->flatMap(function ($order) {
                    return $order->orderDetails->map(function ($detail) {
                        return $detail->quantity * $detail->jewelry->price;
                    });
                })->sum();
            });

        // Dữ liệu biểu đồ thu nhập theo năm
        $yearly_income = Order::where('status', 'Complete')
            ->with(['orderDetails.jewelry'])
            ->get()
            ->groupBy(function ($order) {
                return $order->created_at->format('Y');
            })
            ->map(function ($orders) {
                return $orders->flatMap(function ($order) {
                    return $order->orderDetails->map(function ($detail) {
                        return $detail->quantity * $detail->jewelry->price;
                    });
                })->sum();
            });

        // Dữ liệu số lượng từng loại trang sức đã bán theo năm
        $category_jewelry_sold = Order::where('status', 'Complete')
            ->whereYear('created_at', $year)
            ->with(['orderDetails.jewelry'])
            ->get()
            ->flatMap(function ($order) {
                return $order->orderDetails;
            })
            ->groupBy(function ($detail) {
                return $detail->jewelry->categories;
            })
            ->map(function ($details) {
                return $details->sum('quantity');
            });

        return view('admin.dashboard', [
            'income' => $income,
            'count_customer' => $count_customer,
            'count_order' => $count_order,
            'monthly_income' => $monthly_income,
            'yearly_income' => $yearly_income,
            'category_jewelry_sold' => $category_jewelry_sold,
            'year' => $year,
        ]);
    }
}

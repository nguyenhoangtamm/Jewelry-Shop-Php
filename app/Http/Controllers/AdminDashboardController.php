<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', date('Y')); // Mặc định là năm hiện tại

        // Danh sách các năm có đơn hàng
        $years = Order::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderByDesc('year')
            ->pluck('year');

        // Tổng thu nhập trong năm
       $income = Order::whereRaw('LOWER(status) = ?', ['hoàn thành'])
    ->whereYear('created_at', $year)
    ->with('orderDetails') // Không cần jewelry nữa
    ->get()
    ->flatMap(function ($order) {
        return $order->orderDetails->map(function ($detail) {
            return $detail->quantity * ($detail->unit_price ?? 0); // chắc ăn nhất
        });
    })
    ->sum();


        // Tổng đơn hàng trong năm
        $count_order = Order::whereYear('created_at', $year)->count();

        // Tổng khách hàng
        $count_customer = User::count();

        // Thu nhập theo tháng
        $monthly_income = collect(range(1, 12))->mapWithKeys(function ($month) use ($year) {
            $orders = Order::whereRaw('LOWER(status) = ?', ['hoàn thành'])
                ->whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->with('orderDetails.jewelry')
                ->get();

            $total = $orders->flatMap(function ($order) {
                return $order->orderDetails->map(function ($detail) {
                    return $detail->quantity * optional($detail->jewelry)->price;
                });
            })->sum();

            return [str_pad($month, 2, '0', STR_PAD_LEFT) => $total];
        });

        // Dữ liệu biểu đồ thu nhập theo tháng
        $monthly_income_chart = [];
        foreach (range(1, 12) as $month) {
            $key = str_pad($month, 2, '0', STR_PAD_LEFT);
            $monthly_income_chart[] = $monthly_income->get($key, 0);
        }

        // Thu nhập theo từng năm
        $yearly_income = Order::whereRaw('LOWER(status) = ?', ['hoàn thành'])
            ->with('orderDetails.jewelry')
            ->get()
            ->groupBy(function ($order) {
                return $order->created_at?->format('Y') ?? 'N/A';
            })
            ->map(function ($orders) {
                return $orders->flatMap(function ($order) {
                    return $order->orderDetails->map(function ($detail) {
                        return $detail->quantity * optional($detail->jewelry)->price;
                    });
                })->sum();
            });

        // Thống kê danh mục trang sức đã bán
        $category_jewelry_sold = Order::whereRaw('LOWER(status) = ?', ['hoàn thành'])
            ->whereYear('created_at', $year)
            ->with('orderDetails.jewelry.category')
            ->get()
            ->flatMap(function ($order) {
                return $order->orderDetails->filter(function ($detail) {
                    return $detail->jewelry && $detail->jewelry->category;
                });
            })
            ->groupBy(function ($detail) {
                return $detail->jewelry->category->name;
            })
            ->map(function ($details) {
                return $details->sum('quantity');
            });

        return view('admin.dashboard', [
            'income' => $income,
            'count_customer' => $count_customer,
            'count_order' => $count_order,
            'monthly_income_chart' => $monthly_income_chart,
            'yearly_income' => $yearly_income,
            'category_jewelry_sold' => $category_jewelry_sold,
            'year' => $year,
            'years' => $years,
        ]);
    }
}
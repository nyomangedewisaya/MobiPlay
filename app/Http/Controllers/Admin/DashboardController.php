<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $availableYears = Order::selectRaw('YEAR(created_at) as year')->distinct()->orderBy('year', 'desc')->pluck('year');
        $selectedYear = $request->input('year', date('Y'));

        // Stats for products and items
        $activeProducts = Product::where('status', 'active')->count();
        $totalProducts = Product::count();
        $productPercentage = $totalProducts > 0 ? ($activeProducts / $totalProducts) * 100 : 0;

        $activeItems = Item::where('status', 'active')->count();
        $totalItems = Item::count();
        $itemPercentage = $totalItems > 0 ? ($activeItems / $totalItems) * 100 : 0;

        // Stats for orders dan revenue
        $now = Carbon::now();
        $lastMonth = $now->copy()->subMonthNoOverflow();

        $successfulOrdersThisMonth = Order::where('status', 'success')->whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->count();
        $revenueThisMonth = (int) Order::where('status', 'success')->whereYear('created_at', $now->year)->whereMonth('created_at', $now->month)->sum('total_amount');

        $successfulOrdersLastMonth = Order::where('status', 'success')->whereYear('created_at', $lastMonth->year)->whereMonth('created_at', $lastMonth->month)->count();
        $revenueLastMonth = (int) Order::where('status', 'success')->whereYear('created_at', $lastMonth->year)->whereMonth('created_at', $lastMonth->month)->sum('total_amount');

        $orderPercentageChange = 0;
        if ($successfulOrdersLastMonth > 0) {
            $orderPercentageChange = (($successfulOrdersThisMonth - $successfulOrdersLastMonth) / $successfulOrdersLastMonth) * 100;
        } elseif ($successfulOrdersThisMonth > 0) {
            $orderPercentageChange = 100; 
        }

        $revenuePercentageChange = 0;
        if ($revenueLastMonth > 0) {
            $revenuePercentageChange = (($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100;
        } elseif ($revenueThisMonth > 0) {
            $revenuePercentageChange = 100;
        }

        $productStats = [
            'active' => $activeProducts,
            'total' => $totalProducts,
            'percentage' => round($productPercentage),
        ];

        $itemStats = [
            'active' => $activeItems,
            'total' => $totalItems,
            'percentage' => round($itemPercentage),
        ];

        $orderStats = [
            'count' => $successfulOrdersThisMonth,
            'percentageChange' => round($orderPercentageChange),
        ];

        $revenueStats = [
            'total' => $revenueThisMonth,
            'percentageChange' => round($revenuePercentageChange),
        ];

        // Chart initial
        $revenueByMonth = array_fill(1, 12, 0); 
        $ordersByMonth = array_fill(1, 12, 0);

        // Data for line chart
        $monthlyData = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_amount) as total_revenue'),
            DB::raw('COUNT(*) as order_count') 
        )
        ->where('status', 'success') 
        ->whereYear('created_at', $selectedYear)
        ->groupBy('month')
        ->get();

        foreach ($monthlyData as $data) {
            $revenueByMonth[$data->month] = (int) $data->total_revenue;
            $ordersByMonth[$data->month] = (int) $data->order_count;
        }

        $lineChartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'revenues' => array_values($revenueByMonth),
            'orders' => array_values($ordersByMonth),
        ];

        // Data for doughnut chart
        $statusCounts = Order::select(
            'status',
            DB::raw('COUNT(*) as count')
        )
        ->whereYear('created_at', $selectedYear)
        ->where('status', '!=', 'cancelled')
        ->groupBy('status')
        ->pluck('count', 'status');

        $doughnutChartData = [
            'labels' => $statusCounts->keys()->map(fn($status) => ucfirst($status))->all(),
            'counts' => $statusCounts->values()->all(),
        ];

        // Popular products 
        $popularProducts = Product::select('products.*', DB::raw('COUNT(DISTINCT orders.id) as total_orders'))
            ->join('items', 'products.id', '=', 'items.product_id')
            ->join('order_items', 'items.id', '=', 'order_items.item_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'success')
            ->whereYear('orders.created_at', $selectedYear)
            ->groupBy('products.id') 
            ->orderByDesc('total_orders')
            ->limit(5)
            ->get();

        // Best selling items
        $bestSellingItems = Item::select('items.*', DB::raw('COUNT(order_items.id) as total_sales_count'))
            ->join('order_items', 'items.id', '=', 'order_items.item_id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'success')
            ->whereYear('orders.created_at', $selectedYear)
            ->groupBy('items.id')
            ->orderByDesc('total_sales_count') 
            ->with('product')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'productStats', 
            'itemStats', 
            'orderStats', 
            'revenueStats',
            'availableYears',
            'selectedYear',
            'lineChartData',      
            'doughnutChartData',   
            'popularProducts',   
            'bestSellingItems'   
        ));
    }
}

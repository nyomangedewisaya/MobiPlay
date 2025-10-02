<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $selectedMonth = $request->input('month', 'all');
        $selectedYear = $request->input('year', date('Y'));
        $selectedStatus = $request->input('status', 'all');
        $searchQuery = $request->input('search');

        $query = Order::query()->with(['orderItems.item', 'user']);

        $query->when($searchQuery, function ($q, $search) {
            return $q->where('order_code', 'like', '%' . $search . '%');
        });

        $query->when($selectedYear, fn($q) => $q->whereYear('created_at', $selectedYear));
        $query->when($selectedMonth !== 'all', fn($q) => $q->whereMonth('created_at', $selectedMonth));
        $query->when($selectedStatus !== 'all', fn($q) => $q->where('status', $selectedStatus));

        $orders = $query->latest()->paginate(15);
        $orders->appends($request->all());

        $years = Order::selectRaw('YEAR(created_at) as year')->distinct()->orderBy('year', 'desc')->pluck('year');

        $isFilterActive = $request->has('month') || $request->has('year') || $request->input('status', 'all') !== 'all' || $request->has('search');

        return view('admin.orders.index', compact('orders', 'years', 'selectedMonth', 'selectedYear', 'selectedStatus', 'isFilterActive'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        if ($order->status !== 'pending') {
            return redirect()->route('managements.orders.index')->with('error', 'Hanya pesanan yang tertunda yang bisa diubah statusnya.');
        }

        $validated = $request->validate([
            'status' => ['required', Rule::in(['success', 'failed'])],
        ]);

        $order->update(['status' => $validated['status']]);

        return redirect()->route('orders.index')->with('success', 'Status pesanan berhasil diperbarui.');
    }
}

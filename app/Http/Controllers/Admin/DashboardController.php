<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request) {
        // $selectedYear = $request->input('year', Carbon::now()->year);
        // $availableYears = Order::select(DB::raw('YEAR(created_at) as year'))->distinct()->orderBy('year', 'desc')->pluck('year');

        return view('admin.dashboard');
        // , compact('selectedYear, availableYears')
    }
}

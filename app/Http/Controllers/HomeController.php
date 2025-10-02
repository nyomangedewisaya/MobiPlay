<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Article;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $searchQuery = $request->input('search');
        $isSearchActive = !empty($searchQuery);

        $advertisements = collect(); 
        $categories = collect();
        $searchResults = collect();

        if ($isSearchActive) {
            $searchResults = Product::where('status', 'active')
                ->where('name', 'like', '%' . $searchQuery . '%')
                ->with('category')
                ->get();
        } else {
            $advertisements = Advertisement::where('status', 'active')->latest()->get();

            $categoryOrder = ['New', 'Populer', 'Game', 'Entertainments', 'Voucher'];
            $categories = Category::whereIn('name', $categoryOrder)
                ->with([
                    'products' => function ($query) {
                        $query->where('status', 'active');
                    },
                ])
                ->get()
                ->sortBy(fn($cat) => array_search($cat->name, $categoryOrder));
        }

        $articles = Article::where('status', 'active')->latest()->take(6)->get();

        return view('frontend.home', compact('advertisements', 'categories', 'isSearchActive', 'searchResults', 'searchQuery', 'articles'));
    }

    public function searchHelper(Request $request)
    {
        $request->validate(['q' => 'required|string']);

        $query = $request->input('q');

        $products = Product::where('status', 'active')
            ->where('name', 'like', '%' . $query . '%')
            ->select('name', 'slug', 'thumbnail_url')
            ->limit(5)
            ->get();

        return response()->json($products);
    }

    public function aboutUs() {
        return view('frontend.about-us');
    }

    public function history(Request $request)
    {
        $searchQuery = $request->input('search');
        $dateRange = $request->input('range', 'all'); 

        $query = Order::where('user_id', Auth::id())
                      ->with(['orderItems.item.product']); 

        $query->when($searchQuery, function ($q, $search) {
            return $q->where('order_code', 'like', '%' . $search . '%');
        });

        $query->when($dateRange !== 'all', function ($q) use ($dateRange) {
            $days = (int) $dateRange;
            if ($days > 0) {
                return $q->where('created_at', '>=', Carbon::now()->subDays($days));
            }
        });

        $orders = $query->latest()->get(); 

        return view('frontend.history', compact('orders'));
    }
}

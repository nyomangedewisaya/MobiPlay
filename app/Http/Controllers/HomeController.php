<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

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

        return view('frontend.home', compact('advertisements', 'categories', 'isSearchActive', 'searchResults', 'searchQuery'));
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
}

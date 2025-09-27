<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $allowedOrderBy = ['created_at', 'name', 'status'];
        $allowedOrderDirection = ['asc', 'desc'];
        $allowedPerPage = [10, 25, 50];

        $orderBy = $request->input('order_by', 'created_at');
        if (!in_array($orderBy, $allowedOrderBy)) {
            $orderBy = 'created_at';
        }

        $orderDirection = $request->input('order_direction', 'desc');
        if (!in_array($orderDirection, $allowedOrderDirection)) {
            $orderDirection = 'desc';
        }

        $perPage = (int) $request->input('per_page', 10);
        if (!in_array($perPage, $allowedPerPage)) {
            $perPage = 10;
        }

        $query = Product::query()->with('category');
        $query->when($request->search, function ($q, $search) {
            return $q->where('name', 'like', '%' . $search . '%');
        });
        $query->when($request->category && $request->category !== 'all', function ($q) use ($request) {
            return $q->whereHas('category', function ($subQuery) use ($request) {
                $subQuery->where('slug', $request->category);
            });
        });
        $query->orderBy($orderBy, $orderDirection);

        $products = $query->paginate($perPage);
        $products->appends($request->all());

        $categories = Category::orderBy('name')->get();
        $isFilterActive = count(array_filter($request->except('page'))) > 0;

        return view('admin.managements.products.index', compact('products', 'categories', 'isFilterActive'));
    }
    
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.managements.products.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products,name',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'thumbnail_url' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048|dimensions:ratio=1/1',
            'banner_url' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048|dimensions:ratio=2/1',
        ], [
            'name.required' => 'Nama produk tidak boleh kosong.',
            'name.unique' => 'Nama produk ini sudah digunakan, silakan pilih nama lain.',
            'category_id.required' => 'Anda harus memilih kategori produk.',
            'description.required' => 'Deskripsi produk tidak boleh kosong.',
            'thumbnail_url.required' => 'Gambar thumbnail wajib di-upload.',
            'thumbnail_url.dimensions' => 'Rasio gambar thumbnail harus 1:1 (persegi).',
            'banner_url.required' => 'Gambar banner wajib di-upload.',
            'banner_url.dimensions' => 'Rasio gambar banner harus 2:1 (lebar 2x, tinggi 1x).',
        ]);

        $data = $validated;
        $data['slug'] = Str::slug($validated['name']);
        $data['status'] = 'inactive';

        if ($request->hasFile('thumbnail_url')) {
            $file = $request->file('thumbnail_url');
            $filename = time() . '_thumb_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/products'), $filename);
            $data['thumbnail_url'] = '/images/products/' . $filename;
        }
        
        if ($request->hasFile('banner_url')) {
            $file = $request->file('banner_url');
            $filename = time() . '_banner_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/products'), $filename);
            $data['banner_url'] = '/images/products/' . $filename;
        }

        Product::create($data);

        return redirect()->route('managements.products.index')->with('success', 'Produk baru berhasil ditambahkan.');
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.managements.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('products')->ignore($product->id)],
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'thumbnail_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048|dimensions:ratio=1/1',
            'banner_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048|dimensions:ratio=2/1',
        ], [
            'name.required' => 'Nama produk tidak boleh kosong.',
            'name.unique' => 'Nama produk ini sudah digunakan, silakan pilih nama lain.',
            'category_id.required' => 'Anda harus memilih kategori produk.',
            'description.required' => 'Deskripsi produk tidak boleh kosong.',
            'thumbnail_url.dimensions' => 'Rasio gambar thumbnail harus 1:1 (persegi).',
            'banner_url.dimensions' => 'Rasio gambar banner harus 2:1 (lebar 2x, tinggi 1x).',
        ]);

        $data = $validated;
        $data['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('thumbnail_url')) {
            if ($product->thumbnail_url && File::exists(public_path($product->thumbnail_url))) {
                File::delete(public_path($product->thumbnail_url));
            }
            $file = $request->file('thumbnail_url');
            $filename = time() . '_thumb_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/products'), $filename);
            $data['thumbnail_url'] = '/images/products/' . $filename;
        }

        if ($request->hasFile('banner_url')) {
            if ($product->banner_url && File::exists(public_path($product->banner_url))) {
                File::delete(public_path($product->banner_url));
            }
            $file = $request->file('banner_url');
            $filename = time() . '_banner_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/products'), $filename);
            $data['banner_url'] = '/images/products/' . $filename;
        }

        $product->update($data);

        return redirect()->route('managements.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Product $product)
    {
        if ($product->thumbnail_url && File::exists(public_path($product->thumbnail_url))) {
            File::delete(public_path($product->thumbnail_url));
        }
        if ($product->banner_url && File::exists(public_path($product->banner_url))) {
            File::delete(public_path($product->banner_url));
        }

        $product->delete();

        return redirect()->route('managements.products.index')->with('success', 'Produk berhasil dihapus.');
    }

    public function updateStatus(Request $request, Product $product)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $product->update(['status' => $validated['status']]);

        return redirect()->route('managements.products.index')
                         ->with('success', 'Status produk berhasil diperbarui.');
    }
}

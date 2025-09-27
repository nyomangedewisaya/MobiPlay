<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    public function productList()
    {
        $products = Product::with('category')->withCount('items')->orderBy('name')->get();

        return view('admin.managements.items.product-list', compact('products'));
    }

    public function index(Request $request, Product $product)
    {
        $allowedOrderBy = ['name', 'price', 'status'];
        $allowedOrderDirection = ['asc', 'desc'];

        $orderBy = $request->input('order_by');
        if (!in_array($orderBy, $allowedOrderBy)) {
            $orderBy = 'created_at';
        }

        $orderDirection = $request->input('order_direction', 'desc');
        if (!in_array($orderDirection, $allowedOrderDirection)) {
            $orderDirection = 'desc';
        }

        $query = $product->items();
        $query->orderBy($orderBy, $orderDirection);

        $items = $query->get();

        $isFilterActive = count(array_filter($request->except('page'))) > 0;

        return view('admin.managements.items.index', compact('product', 'items', 'isFilterActive'));
    }

    public function create(Product $product)
    {
        return view('admin.managements.items.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:100', Rule::unique('items')->where('product_id', $product->id)],
                'sku' => 'required|string|max:100|unique:items,sku',
                'price' => 'required|integer|min:0',
                'image_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            ],
            [
                'name.required' => 'Nama item tidak boleh kosong.',
                'name.unique' => 'Nama item ini sudah ada untuk produk ini.',
                'sku.required' => 'SKU tidak boleh kosong.',
                'sku.unique' => 'SKU ini sudah ada untuk produk ini.',
                'price.required' => 'Harga tidak boleh kosong.',
                'image_url.dimensions' => 'Rasio gambar item harus 1:1 (persegi).',
            ],
        );

        $data = $validated;
        $data['product_id'] = $product->id;
        $data['slug'] = Str::slug($validated['name']);
        $data['status'] = 'inactive';

        if ($request->hasFile('image_url')) {
            $file = $request->file('image_url');
            $filename = time() . '_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/items'), $filename);
            $data['image_url'] = '/images/items/' . $filename;
        }

        Item::create($data);

        return redirect()->route('managements.items.index', $product)->with('success', 'Item baru berhasil ditambahkan.');
    }

    public function edit(Item $item)
    {
        return view('admin.managements.items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate(
            [
                'name' => ['required', 'string', 'max:255', Rule::unique('items')->where('product_id', $item->product_id)->ignore($item->id)],
                'sku' => ['required', 'string', 'max:100', Rule::unique('items')->ignore($item->id)],
                'price' => 'required|integer|min:0',
                'image_url' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048|dimensions:ratio=1/1',
            ],
            [
                'name.required' => 'Nama item tidak boleh kosong.',
                'name.unique' => 'Nama item ini sudah ada untuk produk ini.',
                'sku.required' => 'SKU tidak boleh kosong.',
                'sku.unique' => 'SKU ini sudah ada untuk produk ini.',
                'price.required' => 'Harga tidak boleh kosong.',
                'image_url.dimensions' => 'Rasio gambar item harus 1:1 (persegi).',
            ],
        );

        $data = $validated;
        $data['slug'] = Str::slug($validated['name']);

        if ($request->hasFile('image_url')) {
            if ($item->image_url && File::exists(public_path($item->image_url))) {
                File::delete(public_path($item->image_url));
            }
            $file = $request->file('image_url');
            $filename = time() . '_' . Str::slug($validated['name']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/items'), $filename);
            $data['image_url'] = '/images/items/' . $filename;
        }

        $item->update($data);

        return redirect()->route('managements.items.index', $item->product)->with('success', 'Item berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        $product = $item->product;

        if ($item->image_url && File::exists(public_path($item->image_url))) {
            File::delete(public_path($item->image_url));
        }
        $item->delete();

        return redirect()->route('managements.items.index', $product)->with('success', 'Item berhasil dihapus.');
    }

    public function updateStatus(Request $request, Item $item)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,inactive',
        ]);

        $item->update(['status' => $validated['status']]);

        $product = $item->product;

        return redirect()->route('managements.items.index', $product)->with('success', 'Status item berhasil diperbarui.');
    }

    public function updateDiscount(Request $request, Item $item)
    {
        $validated = $request->validate([
            'discount_percentage' => 'required|integer|min:0|max:75',
        ], [
            'discount_percentage.required' => 'Persentase diskon tidak boleh kosong.',
            'discount_percentage.integer' => 'Diskon harus berupa angka.',
            'discount_percentage.max' => 'Diskon maksimal adalah 75%.',
        ]);

        $item->update(['discount_percentage' => $validated['discount_percentage']]);

        return redirect()->route('managements.items.index', $item->product)
                         ->with('success', 'Diskon untuk item berhasil diperbarui.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index(Request $request) {
        $query = Category::query();
        $query->when($request->search, function ($q, $search) {
            return $q->where('name', 'like', '%' . $search . '%');
        });

        $categories = $query->withCount('products')->orderBy('name')->get();
        return view('admin.managements.categories.index', compact('categories'));
    }

    public function create() {
        return view('admin.managements.categories.create');
    }
    
    public function store(Request $request) {
        $validate = $request->validate([
            'name' => 'required|string|max:50|unique:categories,name'
        ], [
            'name.required' => 'Nama kategori tidak boleh kosong.',
            'name.unique' => 'Nama kategori ini sudah tersedia.',
        ]);

        $data = [
            'name' => $validate['name'],
            'slug' => Str::slug($validate['name'])
        ];
        Category::create($data);

        return redirect()->route('managements.categories.index')->with('success', 'Kategori baru berhasil ditambahkan.');
    }
    
    public function edit(Category $category) {
        return view('admin.managements.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category) {
        $validate = $request->validate([
            'name' => ['required', 'string', 'max:50', Rule::unique('categories')->ignore($category->id)]
        ], [
            'name.required' => 'Nama kategori tidak boleh kosong.',
            'name.unique' => 'Nama kategori ini sudah tersedia.',
        ]);

        $data = [
            'name' => $validate['name'],
            'slug' => Str::slug($validate['name'])
        ];
        $category->update($data);

        return redirect()->route('managements.categories.index', compact('category'))->with('success', 'Kategori berhasil diedit.');
    }

    public function destroy(Category $category) {
        if ($category->products()->count() > 0) {
            return redirect()->route('managements.categories.index')->with('error', 'Kategori gagal dihapus karena masih memiiki produk terkait.');
        }
        $category->delete();

        return redirect()->route('managements.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }
}

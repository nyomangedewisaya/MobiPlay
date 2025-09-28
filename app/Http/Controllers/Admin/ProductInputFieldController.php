<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductInputField;
use Illuminate\Validation\Rule;

class ProductInputFieldController extends Controller
{
    public function productList()
    {
        $products = Product::with('category')->withCount('inputFields')->orderBy('name')->get();

        return view('admin.managements.input-fields.product-list', compact('products'));
    }

    public function index(Product $product)
    {
        $inputFields = $product->inputFields()->orderBy('field_label')->get();
        return view('admin.managements.input-fields.index', compact('product', 'inputFields'));
    }

    public function create(Product $product)
    {
        return view('admin.managements.input-fields.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        $validated = $request->validate(
            [
                'field_label' => 'required|string|max:100',
                'field_name' => ['required', 'string', 'max:50', 'alpha_dash', Rule::unique('product_input_fields')->where('product_id', $product->id)],
                'field_type' => 'required|in:text,number,select',
                'field_desc' => 'required|string',
                'placeholder' => 'nullable|string|max:100',
                'validation_rules' => 'required|string|max:50',
                'field_options' => 'required_if:field_type,select|nullable|string',
            ],
            [
                'field_label.required' => 'Field Label tidak boleh kosong.',
                'field_name.alpha_dash' => 'Field Name hanya boleh berisi huruf, angka, tanda hubung (-), dan garis bawah (_).',
                'field_name.unique' => 'Field Name ini sudah ada untuk produk ini.',
                'field_desc.required' => 'Field Deskripsi tidak boleh kosong.',
                'field_options.required_if' => 'Opsi Pilihan wajib diisi jika tipe field adalah Select.',
            ],
        );

        $data = $validated;
        $data['product_id'] = $product->id;

        if ($request->field_type === 'select' && !empty($request->field_options)) {
            $data['field_options'] = json_encode(array_map('trim', explode(',', $request->field_options)));
        }

        ProductInputField::create($data);

        return redirect()->route('managements.products.input-fields.index', $product)->with('success', 'Input field baru berhasil ditambahkan.');
    }

    public function edit(ProductInputField $productInputField)
    {
        $product = $productInputField->product;
        return view('admin.managements.input-fields.edit', compact('productInputField', 'product'));
    }

    public function update(Request $request, ProductInputField $productInputField)
    {
        $product = $productInputField->product;
        $validated = $request->validate([
            'field_label' => 'required|string|max:100',
            'field_name' => ['required', 'string', 'max:50', 'alpha_dash', Rule::unique('product_input_fields')->where('product_id', $product->id)->ignore($productInputField->id)],
            'field_type' => 'required|in:text,number,select',
            'field_desc' => 'required|string',
            'placeholder' => 'nullable|string|max:100',
            'validation_rules' => 'required|string|max:50',
            'field_options' => 'required_if:field_type,select|nullable|string',
        ]);

        $data = $validated;
        if ($request->field_type === 'select' && !empty($request->field_options)) {
            $data['field_options'] = json_encode(array_map('trim', explode(',', $request->field_options)));
        } else {
            $data['field_options'] = null;
        }

        $productInputField->update($data);

        return redirect()->route('managements.products.input-fields.index', $product)->with('success', 'Input field berhasil diperbarui.');
    }

    public function destroy(ProductInputField $productInputField)
    {
        $product = $productInputField->product;
        $productInputField->delete();

        return redirect()->route('managements.products.input-fields.index', $product)->with('success', 'Input field berhasil dihapus.');
    }
}

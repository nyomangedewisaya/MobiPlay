<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function show(Product $product)
    {
        if ($product->status !== 'active') {
            abort(404, 'Produk tidak tersedia.');
        }

        $product->load([
            'inputFields',
            'items' => function ($query) {
                $query->where('status', 'active');
            },
        ]);

        $taxRate = 0.11;
        $paymentMethods = [
            'E-Wallet' => ['Dana', 'OVO', 'GoPay', 'ShopeePay'],
            'Transfer Bank' => ['BCA', 'Mandiri', 'BNI', 'BRI'],
            'Convenience Store' => ['Alfamart', 'Indomaret'],
        ];

        return view('frontend.transaction', compact('product', 'taxRate', 'paymentMethods'));
    }

    public function checkout(Request $request, Product $product)
    {
        $dynamicRules = [];
        $userData = [];
        foreach ($product->inputFields as $field) {
            $dynamicRules[$field->field_name] = $field->validation_rules;
            $userData[$field->field_label] = $request->input($field->field_name);
        }
        
        if (!Auth::check()) {
            $dynamicRules['customer_email'] = 'required|email';
        }

        $request->validate(array_merge([
            'item_id' => 'required|exists:items,id',
            'payment_method' => 'required|string',
        ], $dynamicRules));

        $item = Item::findOrFail($request->item_id);
        if ($item->product_id !== $product->id || $item->status !== 'active') {
            return back()->with('error', 'Item yang dipilih tidak valid.');
        }
        
        $taxRate = 0.11;
        $price = $item->price;
        if ($item->discount_percentage > 0) {
            $price -= ($price * ($item->discount_percentage / 100));
        }
        $taxAmount = $price * $taxRate;
        $totalAmount = round($price + $taxAmount);

        $order = null;
        try {
            DB::transaction(function () use ($request, $item, $totalAmount, $userData, &$order) {
                $user = Auth::user();
                $orderCode = 'MPL-' . time() . '-' . Str::upper(Str::random(5));
                $transactionId = 'TRF-' . Str::upper(Str::random(12)) . Str::upper(Str::random(8));

                $order = Order::create([
                    'user_id' => $user->id ?? null,
                    'user_email' => $user->email ?? $request->customer_email,
                    'order_code' => $orderCode,
                    'midtrans_transaction_id' => $transactionId,
                    'total_amount' => $totalAmount,
                    'status' => 'pending',
                ]);

                $order->orderItems()->create([
                    'item_id' => $item->id,
                    'price_purchase' => $item->price,
                    'discount_purchase' => $item->discount_percentage,
                    'user_data' => json_encode($userData),
                ]);
            });
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan saat membuat pesanan. Silakan coba lagi.');
        }
        
        return redirect()->route('transaction.success', $order);
    }

    public function success(Order $order)
    {
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load(['orderItems.item.product', 'user']);

        return view('frontend.checkout', compact('order'));
    }
}

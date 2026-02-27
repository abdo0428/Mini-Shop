<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CartController extends Controller
{
    public function show(CartService $cart)
    {
        return view('cart.index', [
            'cart' => $cart->all(),
            'subtotal' => $cart->subtotal(),
        ]);
    }

    public function summary(CartService $cart)
    {
        return response()->json([
            'count' => $cart->countItems(),
            'subtotal' => number_format($cart->subtotal(), 2),
        ]);
    }

    public function mini(CartService $cart)
    {
        $items = collect($cart->all())
            ->sortByDesc(fn ($row) => $row['added_at'] ?? 0)
            ->take(3)
            ->values()
            ->map(function ($row) {
                $imageUrl = null;
                if (!empty($row['image'])) {
                    $path = ltrim((string) $row['image'], '/');
                    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                        $imageUrl = $path;
                    } elseif (str_starts_with($path, 'storage/')) {
                        $imageUrl = asset($path);
                    } else {
                        $imageUrl = Storage::url($path);
                    }
                }

                return [
                    'product_id' => $row['product_id'],
                    'name' => $row['name'],
                    'qty' => (int) $row['qty'],
                    'unit_price' => (float) $row['unit_price'],
                    'line_total' => (float) ($row['unit_price'] * $row['qty']),
                    'image_url' => $imageUrl,
                ];
            });

        return response()->json([
            'count' => $cart->countItems(),
            'subtotal' => number_format($cart->subtotal(), 2),
            'items' => $items,
        ]);
    }

    public function add(Request $request, CartService $cart)
    {
        $data = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty' => ['nullable','integer','min:1','max:999'],
        ]);

        $product = Product::where('is_active', true)->findOrFail($data['product_id']);

        // optional stock check
        if ($product->stock <= 0) {
            return response()->json(['message' => 'Out of stock'], 422);
        }

        $row = $cart->add($product, (int)($data['qty'] ?? 1));

        return response()->json([
            'message' => 'Added to cart',
            'row' => $row,
            'count' => $cart->countItems(),
            'subtotal' => number_format($cart->subtotal(), 2),
        ]);
    }

    public function update(Request $request, CartService $cart)
    {
        $data = $request->validate([
            'product_id' => ['required','integer'],
            'qty' => ['required','integer','min:0','max:999'],
        ]);

        $cart->updateQty((int)$data['product_id'], (int)$data['qty']);

        return response()->json([
            'message' => 'Cart updated',
            'count' => $cart->countItems(),
            'subtotal' => number_format($cart->subtotal(), 2),
        ]);
    }

    public function remove(Request $request, CartService $cart)
    {
        $data = $request->validate([
            'product_id' => ['required','integer'],
        ]);

        $cart->remove((int)$data['product_id']);

        return response()->json([
            'message' => 'Removed',
            'count' => $cart->countItems(),
            'subtotal' => number_format($cart->subtotal(), 2),
        ]);
    }

    public function clear(CartService $cart)
    {
        $cart->clear();

        return response()->json([
            'message' => 'Cart cleared',
            'count' => 0,
            'subtotal' => number_format(0, 2),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // checkout requires login
    }

    public function confirm(CartService $cart)
    {
        $items = $cart->all();
        if (count($items) === 0) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        return view('checkout.confirm', [
            'cart' => $items,
            'subtotal' => $cart->subtotal(),
        ]);
    }

    public function placeOrder(CartService $cart)
    {
        $items = $cart->all();
        if (count($items) === 0) {
            return redirect()->route('shop.index')->with('error', 'Your cart is empty.');
        }

        $userId = auth()->id();

        $order = DB::transaction(function () use ($items, $userId, $cart) {

            // lock products to avoid race condition
            $productIds = array_map(fn($x) => $x['product_id'], $items);
            $products = Product::whereIn('id', $productIds)->lockForUpdate()->get()->keyBy('id');

            // verify stock
            foreach ($items as $row) {
                $p = $products[$row['product_id']] ?? null;
                if (!$p || !$p->is_active) {
                    throw new \RuntimeException("Invalid product in cart.");
                }
                if ($p->stock < $row['qty']) {
                    throw new \RuntimeException("Not enough stock for {$p->name}.");
                }
            }

            $subtotal = $cart->subtotal();
            $order = Order::create([
                'user_id' => $userId,
                'status' => 'completed',
                'subtotal' => $subtotal,
                'total' => $subtotal,
            ]);

            foreach ($items as $row) {
                $p = $products[$row['product_id']];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $p->id,
                    'qty' => $row['qty'],
                    'unit_price' => $p->price,
                    'line_total' => $p->price * $row['qty'],
                ]);

                $p->decrement('stock', $row['qty']);
            }

            return $order;
        });

        $cart->clear();

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
    }
}
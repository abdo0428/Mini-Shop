<?php
namespace App\Services;

use App\Models\Product;

class CartService
{
    private string $key = 'cart';

    public function all(): array
    {
        return session()->get($this->key, []);
    }

    public function countItems(): int
    {
        $cart = $this->all();
        return array_sum(array_column($cart, 'qty'));
    }

    public function subtotal(): float
    {
        $cart = $this->all();
        $sum = 0;
        foreach ($cart as $row) {
            $sum += ($row['unit_price'] * $row['qty']);
        }
        return (float) $sum;
    }

    public function add(Product $product, int $qty = 1): array
    {
        $cart = $this->all();
        $id = (string) $product->id;

        if (!isset($cart[$id])) {
            $cart[$id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'unit_price' => (float) $product->price,
                'qty' => 0,
                'image' => $product->image,
                'added_at' => time(),
            ];
        }

        $cart[$id]['qty'] += max(1, $qty);
        $cart[$id]['added_at'] = time();
        session()->put($this->key, $cart);

        return $cart[$id];
    }

    public function updateQty(int $productId, int $qty): void
    {
        $cart = $this->all();
        $id = (string) $productId;

        if (!isset($cart[$id])) return;

        if ($qty <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id]['qty'] = $qty;
        }

        session()->put($this->key, $cart);
    }

    public function remove(int $productId): void
    {
        $cart = $this->all();
        $id = (string) $productId;
        unset($cart[$id]);
        session()->put($this->key, $cart);
    }

    public function clear(): void
    {
        session()->forget($this->key);
    }
}

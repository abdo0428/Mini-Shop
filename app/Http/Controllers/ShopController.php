<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function landing()
    {
        $latestProducts = Product::query()
            ->where('is_active', true)
            ->orderByDesc('id')
            ->take(8)
            ->get();

        $latestSection = $latestProducts->take(4);

        $topSellerIds = OrderItem::query()
            ->select('product_id', DB::raw('SUM(qty) as total_qty'))
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(4)
            ->pluck('product_id');

        if ($topSellerIds->isNotEmpty()) {
            $ids = $topSellerIds->toArray();
            $topSellers = Product::query()
                ->where('is_active', true)
                ->whereIn('id', $ids)
                ->orderByRaw('FIELD(id, ' . implode(',', $ids) . ')')
                ->get();
        } else {
            $topSellers = collect();
        }

        if ($topSellers->isEmpty()) {
            $topSellers = Product::query()
                ->where('is_active', true)
                ->orderByDesc('id')
                ->take(4)
                ->get();
        }

        return view('landing', [
            'latestProducts' => $latestProducts,
            'latestSection' => $latestSection,
            'topSellers' => $topSellers,
        ]);
    }

    public function index()
    {
        $products = Product::query()
            ->where('is_active', true)
            ->orderByDesc('id')
            ->paginate(12);

        return view('shop.index', compact('products'));
    }

    public function show(Product $product)
    {
        if (!$product->is_active) {
            abort(404);
        }

        return view('products.show', compact('product'));
    }
}

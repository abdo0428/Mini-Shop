<?php

namespace App\Http\Controllers\Admin;

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderAdminController extends Controller
{
    public function index()
    {
        return view('admin.orders.index');
    }

    public function datatable()
    {
        $orders = Order::with('user')
            ->withCount('items')
            ->orderByDesc('id')
            ->get()
            ->map(function ($o) {
                return [
                    'id' => $o->id,
                    'user' => $o->user?->name,
                    'status' => $o->status,
                    'items_count' => $o->items_count,
                    'total' => (string) $o->total,
                    'created_at' => $o->created_at->format('Y-m-d H:i'),
                ];
            });

        return response()->json(['data' => $orders]);
    }

    public function show(Order $order)
    {
        $order->load(['user','items.product']);
        return view('admin.orders.show', compact('order'));
    }
}
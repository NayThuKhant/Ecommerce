<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cancellation;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        return Auth::user()->orders->load('items.variant.product');
    }

    public function manageOrder($id)
    {
        return Auth::user()->orders->find($id)->load('orderStatus')->load('user')->load('items.variant.product');
    }

    function cancelOrder($id, Request $request)
    {
        $data = $request->validate([
            'reason' => ['required', 'string']
        ]);
        $order = Order::findOrFail($id);
        $order->cancellation()->save(new Cancellation(['reason' => $data['reason']]));
    }

    public function create(Request $request)
    {
        $variants = Auth::user()->cart->variants;

        $sub_total = 0;
        $shipping_fee = 0;

        foreach ($variants as $variant) {
            $sub_total += $variant->pivot->sub_total;
        }

        foreach ($variants as $variant) {
            if ($variant->shipping_fee > $shipping_fee) {
                $shipping_fee = $variant->shipping_fee;
            }
        }

        $order = Order::create([
            'user_id' => Auth::user()->id,
            'payment_method' => $request->payment_method,
            'subtotal' => $sub_total,
            'shipping_fee' => $shipping_fee,
            'discount' => 0,
            'total' => $sub_total + $shipping_fee,
        ]);

        $order->orderStatus()->save(new OrderStatus());

        foreach ($variants as $variant) {
            Item::create([
                'order_id' => $order->id,
                'variant_id' => $variant->id,
                'name' => $variant->name,
                'SKU' => $variant->SKU,
                'featured_photo' => $variant->photos,
                'price' => $variant->special_price * $variant->carts->where('user_id', Auth::user()->id)->first()->pivot->quantity,
                'quantity' => $variant->carts->where('user_id', Auth::user()->id)->first()->pivot->quantity,
            ]);
        }
    }
}

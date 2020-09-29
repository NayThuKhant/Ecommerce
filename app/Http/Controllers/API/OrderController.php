<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cancellation;
use App\Models\Item;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Voucher;
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

        $sub_total = Auth::user()->cart->sub_total;
        $shipping_fee = Auth::user()->cart->shipping_fee;

        $cart = Auth::user()->cart;

        $order = Order::create([
            'user_id' => Auth::user()->id,
            'address_id' => $request->address_id,
            'subtotal' => $sub_total,
            'shipping_fee' => $shipping_fee,
            'discount' => $cart->discount,
            'total' => ($sub_total + $shipping_fee) - $cart->discount,
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


        if ($cart->discount > 0) {
            $voucher = Voucher::where('code', $cart->voucher)->first();
            $voucher->voucher_count -= 1;
            $voucher->save();
            $this->removeVoucher();
        }
    }

    public function applyVoucher(Request $request)
    {
        $voucher = strtoupper($request['voucher']);

        $existed_code = Voucher::where('code', $voucher)->where('is_active', true)->first();
        $cart = Auth::user()->cart;

        if ($existed_code) {
            if ($existed_code->is_working) {
                if ($cart->sub_total > $existed_code->min_order_val) {
                    if ($existed_code->type == 'percentage') {
                        $cart->discount = $cart->sub_total * ($existed_code->value / 100);

                    } else if ($existed_code->type == 'money') {
                        $cart->discount = $existed_code->value;
                    }
                    $cart->voucher = $voucher;
                    $cart->save();
                    return response('Voucher has been applied');
                } else {
                    $this->removeVoucher();
                    return response('minimum amount required to use this code is ' . $existed_code->min_order_val . ' MMK');
                }
            } else {
                $this->removeVoucher();
                return response('Voucher is expired');
            }
        } else {
            $this->removeVoucher();
            return response('Invalid Code');
        }
    }

    public function removeVoucher()
    {
        $cart = Auth::user()->cart;
        $cart->discount = 0;
        $cart->voucher = '';
        $cart->save();
    }

    //For authorization purpose
    public function idIndex()
    {
        if(Auth::check()) {
            return Auth::user()->orders->pluck('id');
        }
        else {
            return [];
        }
    }
}

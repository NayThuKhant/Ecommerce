<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Variant;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Ramsey\Uuid\Rfc4122\VariantTrait;
use function GuzzleHttp\Promise\queue;

class CartController extends Controller
{
    public function index()
    {
        return Auth::user()->cart->variants->load('product');
    }
    public function addToCart(Variant $variant, Request $request)
    {
        $variants_instance = Auth::user()->cart->variants();
        $variant_in_cart = $variants_instance->find($variant->id);
        if($variant_in_cart != null)
        {
            $pivot = $variant_in_cart->pivot;
            $pivot->quantity += $request->quantity;
            $pivot->sub_total = 0;
            $pivot->save();
            $pivot->sub_total = $variant -> special_price * $pivot->quantity;
            $pivot ->save() ;
        }
        else {
            $variants_instance->attach($variant,['quantity' => $request->quantity,'sub_total' => $variant->special_price * $request->quantity]);
        }
    }
    public function removeFromCart(Variant $variant)
    {
        Auth::user()->cart->variants()->detach($variant);
    }
    public function decreaseFormCart(Variant $variant)
    {
       $pivot = Auth::user()->cart->variants->find($variant)->pivot;
       $pivot->quantity -= 1;
       $pivot->save();
       $pivot->sub_total = $variant -> special_price * $pivot->quantity;
       $pivot->save();
    }
    public function increaseToCart(Variant $variant)
    {
       $pivot = Auth::user()->cart->variants->find($variant)->pivot;
       $pivot->quantity += 1;
       $pivot->save();
       $pivot->sub_total = $variant -> special_price * $pivot->quantity;
       $pivot->save();
    }
    public function getCurrentQuantityInCart(Variant $variant)
    {
        $variant = Auth::user()->cart->variants()->find($variant->id);
        if (!$variant) {
            return ['current_quantity' => 0];
        }
        return ['current_quantity' => $variant->pivot->quantity];
    }

    public function clear()
    {
        Auth::user()->cart->variants()->sync([]);
    }

    public function counter()
    {
        return $counter = Auth::user()->cart->variants()->count();
    }
}


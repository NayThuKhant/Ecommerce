<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Variant;
use Illuminate\Http\Request;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use function GuzzleHttp\Promise\queue;

class CartController extends Controller
{
    public function index()
    {
        return Auth::user()->cart->variants;
    }
    public function addToCart(Variant $variant, Request $request)
    {
        $variants_instance = Auth::user()->cart->variants();
        $variant_in_cart = $variants_instance->find($variant->id);
        if($variant_in_cart != null)
        {
            $pivot = $variant_in_cart->pivot;
            $pivot->quantity += $request->quantity;
            $pivot->save();
        }
        else {
            $variants_instance->attach($variant,['quantity' => $request->quantity]);
        }
    }
    public function getCurrentQuantityInCart(Variant $variant)
    {
        $variant = Auth::user()->cart->variants()->find($variant->id);
        if (!$variant) {
            return ['current_quantity' => 0];
        }
        return ['current_quantity' => $variant->pivot->quantity];
    }

    public function counter()
    {
        return $counter = Auth::user()->cart->variants()->count();
    }
}


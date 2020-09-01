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
        $existed_in_cart = Auth::user()->cart->variants()->find($variant->id)->exists();

        if ($existed_in_cart)
        {
            $pivot = Auth::user()->cart->variants()->find($variant->id)->pivot;
            $pivot->quantity = $request->quantity;
            $pivot->save();
        }
        else {
            Auth::user()->cart->variants()->attach($variant,['quantity' => $request->quantity]);
        }
    }
}


<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return Product::paginate(20);
    }
    public function show(Product $product)
    {
        return $product->load('variants');
    }
    public function search(Request $request)
    {
        $keyword = $request->q;
        $products = Product::select('name', 'id')->where('name', 'LIKE', "%{$keyword}%")->limit(10)->get()->makeHidden('min_price');
        return $products;
    }

}

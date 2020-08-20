<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use CrudTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'variant_id',
        'quantity',
        'is_available',
        'sale_price',
        'special_price',
        'shipping_fee_multiplier',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'product_id' => 'integer',
        'variant_id' => 'integer',
        'quantity' => 'integer',
        'is_available' => 'boolean',
        'sale_price' => 'double',
        'special_price' => 'double',
        'shipping_fee_multiplier' => 'double',
    ];


    public function carts()
    {
        return $this->hasMany(\App\Models\Cart::class);
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(\App\Models\Variant::class);
    }
}

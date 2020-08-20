<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'package_id',
        'product_id',
        'variant_id',
        'quantity',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'package_id' => 'integer',
        'product_id' => 'integer',
        'variant_id' => 'integer',
        'quantity' => 'integer',
    ];


    public function package()
    {
        return $this->belongsTo(\App\Models\Package::class);
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_method',
        'subtotal',
        'shipping_fee',
        'discount',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'subtotal' => 'double',
        'shipping_fee' => 'double',
        'discount' => 'double',
    ];


    public function packages()
    {
        return $this->hasMany(\App\Models\Package::class);
    }

    public function orderStatus()
    {
        return $this->hasOne(\App\Models\OrderStatus::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];
    protected $appends = [
        'sub_total',
        'shipping_fee',
        'total'
    ];


    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }

    public function variants()
    {
        return $this->belongsToMany(\App\Models\Variant::class)->withPivot(['quantity','sub_total']);
    }

    public function getSubTotalAttribute() {
        $sub_total = 0;
        foreach ($this->variants as $variant) {
            $sub_total += $variant->pivot->sub_total;
        }
        return $sub_total;
    }

    public function getShippingFeeAttribute() {
        $shipping_fee = 0;
        foreach ($this->variants as $variant) {
            if ($variant->shipping_fee > $shipping_fee) {
                $shipping_fee = $variant->shipping_fee;
            }
        }
        return $shipping_fee;
    }
    public function getTotalAttribute() {
        return ($this->shipping_fee + $this->sub_total) - $this->discount;
    }
}

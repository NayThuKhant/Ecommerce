<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'paid_at',
        'confirmed_at',
        'processed_at',
        'shipped_at',
        'delivered_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'order_id' => 'integer',
    ];


    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'paid_at',
        'confirmed_at',
        'processed_at',
        'shipped_at',
        'delivered_at',
    ];


    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class);
    }
}

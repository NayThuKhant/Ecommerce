<?php

namespace App\Models;

use App\User;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use CrudTrait;
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
        'total',
        'user_id'
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


    public function items()
    {
        return $this->hasMany(\App\Models\Item::class);
    }
    public function orderStatus()
    {
        return $this->hasOne(\App\Models\OrderStatus::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

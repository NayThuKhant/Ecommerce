<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
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


    public function items()
    {
        return $this->hasMany(\App\Models\Item::class);
    }

    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class);
    }
}

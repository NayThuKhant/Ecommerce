<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use CrudTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'color_family',
        'photos',
        'SKU',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'product_id' => 'integer',
        'photos' => 'array'
    ];


    public function items()
    {
        return $this->hasMany(\App\Models\Item::class);
    }

    public function stock()
    {
        return $this->hasOne(\App\Models\Stock::class);
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }
}

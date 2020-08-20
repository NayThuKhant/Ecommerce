<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use CrudTrait;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'highlight',
        'description',
        'included',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
    ];


    public function categories()
    {
        return $this->belongsToMany(\App\Models\Category::class);
    }

    public function variants()
    {
        return $this->hasMany(\App\Models\Variant::class);
    }

    public function carts()
    {
        return $this->hasMany(\App\Models\Cart::class);
    }

    public function items()
    {
        return $this->hasMany(\App\Models\Item::class);
    }

    public function stocks()
    {
        return $this->hasMany(\App\Models\Stock::class);
    }
}

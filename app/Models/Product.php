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
        'featured_photo',
        'is_active'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer'
    ];


    public function is_any_vari_available()
    {
        return $this->variants()->whereIsAvailable(true)->exists();
    }

    //Accessors
    public function getTotalStocksAttribute()
    {
        return $this->variants->pluck('stocks')->sum();
    }

    public function getIsVisibleAttribute()
    {
        if ($this->total_stocks > 0 && $this->is_active && $this->is_any_vari_available())
        {
            return true;
        }
        return false;
    }


    //Relationships
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

}

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
    protected $appends = [
        'min_price'
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
    public function getMinPriceAttribute()
    {
        $variants = $this->variants()->select('sale_price', 'special_price')->get();
        $min = $variants[0]->sale_price ?? 0;
        foreach ($variants as $variant)
        {
            if ($variant->sale_price < $min || $variant->special_price < $min)
            {
                if ($variant->special_price != 0 )
                {
                    $min = $variant->special_price;
                }
                else
                {
                    $min = $variant->sale_price;
                }
            }
        }
        return $min;
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{

    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'full_name',
        'phone',
        'address',
        'city',
        'township',
        'region',
    ];

    protected $appends = [
        'full_address'
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

    protected $dates = ['deleted_at'];


    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function orders() {
        return $this->hasMany(Order::class);
    }
    public function getFullAddressAttribute() {
        return
            $this->address . ' / ' .
            $this->township . ' / ' .
            $this->city;
    }
}

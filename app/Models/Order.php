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

    protected $appends = [
        'final_status',
        'is_cancellable'
    ];

    public function cancellation()
    {
        return $this->hasOne(Cancellation::class);
    }

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

    public function getFinalStatusAttribute()
    {
        if ($this->cancellation()->exists()) {
            return 'cancelled';
        } else {
            if ($this->orderStatus->delivered_at) {
                return 'delivered / ended';
            } else if ($this->orderStatus->shipped_at) {
                return 'shipped';
            } else if ($this->orderStatus->processed_at) {
                return 'processed';
            } else if ($this->orderStatus->confirmed_at) {
                return 'confirmed';
            } else {
                return 'pending';
            }
        }
    }

    public function getIsCancellableAttribute()
    {
        $status = $this->getFinalStatusAttribute();
        if ($status == 'pending' || $status == 'confirmed' || $status == 'proceeded') {
            return true;
        } else {
            return false;
        }
    }
}

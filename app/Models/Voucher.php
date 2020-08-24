<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use CrudTrait;
    protected $fillable = [
        'name',
        'code',
        'start_from',
        'end_at',
        'type',
        'value',
        'min_order_val',
        'initial_voucher_count',
        'voucher_count',
        'is_active'
    ];
    //mutators
    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }
    public function getIsWorkingAttribute()
    {
        if ($this->is_active &&
            Carbon::now()->lessThan(Carbon::parse($this->end_at)) &&
            $this->voucher_count > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}

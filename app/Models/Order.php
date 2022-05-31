<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'amount', 'shipping_address', 'billing_address', 'delivery_time', 'status'
    ];

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function delayedOrder()
    {
        return $this->hasMany(DelayedOrder::class);
    }
    
}

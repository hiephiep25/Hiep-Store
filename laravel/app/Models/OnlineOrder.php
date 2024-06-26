<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineOrder extends Model
{
    use HasFactory;

    const ONLINE_PAYMENT = 'online_payment';
    const PAY_LATER = 'pay_later';

    protected $fillable = [
        'order_id',
        'user_id',
        'payment_type',
        'customer_address',
        'customer_phone',
        'delivery_date',
        'actual_delivery_date',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

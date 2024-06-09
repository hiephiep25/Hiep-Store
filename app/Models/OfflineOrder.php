<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfflineOrder extends Model
{
    use HasFactory;

    const CASH = 'CASH';
    const CARD = 'CARD';
    const E_WALLET = 'E_WALLET';

    protected $fillable = [
        'order_id', 'staff_id', 'payment_type'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

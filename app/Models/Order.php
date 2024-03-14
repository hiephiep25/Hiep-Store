<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const ONLINE = 'ONLINE';
    const OFFLINE = 'OFFLINE';

    const CASH = 'CASH';
    const CARD = 'CARD';
    const E_WALLET = 'E_WALLET';

    protected $fillable = [
        'type',
        'payment_type',
        'total',
        'store_id'
    ];

    public function onlineOrder()
    {
        return $this->hasOne(OnlineOrder::class);
    }

    public function offlineOrder()
    {
        return $this->hasOne(OfflineOrder::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products', 'order_id', 'product_id')
            ->withPivot('qty')
            ->withTimestamps();
    }
}

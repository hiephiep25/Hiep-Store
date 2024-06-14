<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    const ONLINE = 'ONLINE';
    const OFFLINE = 'OFFLINE';

    const PENDING = 'pending';
    const IN_PROGRESS = 'in_progress';
    const COMPLETE = 'complete';

    protected $fillable = [
        'type',
        'total',
        'store_id',
        'status'
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

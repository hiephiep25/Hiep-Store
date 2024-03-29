<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'brand', 'category', 'description', 'qty', 'price_per_qty',
        'manufacture_day', 'expiry_day', 'image'
    ];

    protected $appends = ['availability'];

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }

    public function stores()
    {
        return $this->hasOne(Store::class, 'product_code', 'code');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products', 'product_id', 'order_id')
            ->withPivot('qty')
            ->withTimestamps();
    }

    public function getAvailabilityAttribute(): bool
    {
        $today = Carbon::now();

        return $this->expiry_day > $today && $this->qty > 0;
    }
}

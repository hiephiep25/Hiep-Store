<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'brand', 'category_id', 'description', 'qty', 'price_per_qty',
        'manufacture_day', 'expiry_day', 'image'
    ];

    protected $appends = ['availability'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productStores()
    {
        return $this->hasOne(ProductStore::class, 'product_code', 'code');
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products', 'product_id', 'order_id')
            ->withPivot('qty')
            ->withTimestamps();
    }

    public function processes()
    {
        return $this->hasMany(Process::class, 'product_code');
    }

    public function getAvailabilityAttribute(): bool
    {
        $today = Carbon::now();

        return $this->expiry_day > $today && $this->qty > 0;
    }

    public function scopeAvailable($query)
    {
        $today = Carbon::now();

        return $query->where('expiry_day', '>', $today)
                     ->where('qty', '>', 0);
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'discount_products')
                    ->withPivot('value', 'qty');
    }
}

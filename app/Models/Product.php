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

    public function getAvailabilityAttribute(): bool
    {
        $today = Carbon::now();

        return $this->expiry_day > $today && $this->qty > 0;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code', 'name', 'brand', 'category', 'description', 'qty', 'price_per_qty',
        'manufacture_day', 'expiry_day', 'image'
    ];

    protected $appends = ['availability'];

    public function getAvailabilityAttribute(): bool
    {
        $today = Carbon::now();

        $qty = (int)$this->qty;

        return $this->expiry_day > $today && $qty > 0;
    }
}

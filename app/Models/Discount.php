<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'description', 'start', 'end', 'image'
    ];

    protected $appends = ['availability'];

    public function getAvailabilityAttribute(): bool
    {
        $today = Carbon::now();

        return $this->end > $today && $this->start <= $today;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'discount_product');
    }
}

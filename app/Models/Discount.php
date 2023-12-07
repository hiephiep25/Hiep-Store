<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'value', 'description', 'quantity', 'expiration_date'
    ];

    protected $appends = ['availability'];

    public function getAvailabilityAttribute(): bool
    {
        $today = Carbon::now();

        $quantity = (int)$this->quantity;

        return $this->expiration_date > $today && $quantity > 0;
    }

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }
}

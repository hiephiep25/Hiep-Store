<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfflineOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'store', 'staff_id'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}

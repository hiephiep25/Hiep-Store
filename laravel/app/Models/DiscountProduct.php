<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class DiscountProduct extends Model
{
    use HasFactory;

    protected $table = 'discount_products';

    protected $fillable = [
        'discount_id', 'product_id', 'value', 'qty'
    ];
}

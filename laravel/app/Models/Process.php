<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    const COOKING = 'COOKING';
    const DONATE = 'DONATE';
    const DESTROY = 'DESTROY';

    use HasFactory;
    protected $table = 'process';

    protected $fillable = [
        'product_code',
        'qty',
        'store_id',
        'option'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_code');
    }
}

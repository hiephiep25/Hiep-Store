<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    use HasFactory;

    protected $fillable = [
        'storage', 'product_code', 'quantity'
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'code', 'product_code');
    }

    protected $appends = ['product_name', 'image'];

    public function getProductNameAttribute()
    {
        return $this->product->name;
    }

    public function getImageAttribute()
    {
        return $this->product->image;
    }
}

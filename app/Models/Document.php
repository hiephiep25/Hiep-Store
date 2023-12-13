<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    const AWAIT_APPROVAL = 'AWAIT_APPROVAL';
    const APPROVED = 'APPROVED';
    const DENIED = 'DENIED';
    
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'product_name',
        'qty',
        'category',
        'description',
        'price',
        'manufacture_day',
        'expiry_day',
        'image',
        'license_company',
        'license_product',
    ];

    protected $dates = [
        'manufacture_day',
        'expiry_day',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}

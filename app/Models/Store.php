<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    const ACTIVE = 'ACTIVE';
    const PENDING = 'PENDING';

    use HasFactory;

    protected $fillable = [
        'address', 'phone_contact', 'status'
    ];
}

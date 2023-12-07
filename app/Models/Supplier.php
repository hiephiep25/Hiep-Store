<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'company_address',
        'company_contact',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

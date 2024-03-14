<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    const WORK = 'WORK';
    const QUIT = 'QUIT';
    
    use HasFactory;
    protected $table = 'staffs';

    protected $fillable = [
        'user_id',
        'store_id',
        'phone_number',
        'address',
        'dob',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

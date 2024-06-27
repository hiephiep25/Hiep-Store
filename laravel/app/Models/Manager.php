<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'store_id',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    protected $appends = ['user_name', 'user_email'];

    public function getUserNameAttribute()
    {
        return $this->user->name;
    }

    public function getUserEmailAttribute()
    {
        return $this->user->email;
    }
}

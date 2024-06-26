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
        'status'
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

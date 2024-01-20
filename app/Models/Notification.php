<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = ['sender_id', 'receiver_id', 'type', 'content', 'is_read', 'created_at', 'updated_at',];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function getCreatedAtAttribute($value)
    {
        $createdAt = Carbon::parse($value);

        if ($createdAt->diffInDays() > 3) {
            return $createdAt->format('d-m-Y');
        }

        return $createdAt->diffForHumans();
    }
}

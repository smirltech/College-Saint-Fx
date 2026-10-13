<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Otp extends Model
{
    use HasFactory, Notifiable;

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    protected $guarded = [];

    public function hasExpired()
    {
        if ($this->updated_at->diffInMinutes() > config('auth.otp.expire')) {
            return $this->delete();
        }

        return false;
    }

    public function routeNotificationForMail($notification)
    {
        return $this->identifier;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lecture extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $with = [
        'user', 'ouvrage',
    ];

    public function ouvrage(): BelongsTo
    {
        return $this->belongsTo(Ouvrage::class, 'ouvrage_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function uniqueVisits()
    {
        return self::all()->unique('user_id');
    }

    public static function uniqueVisitsCount()
    {
        return self::uniqueVisits()->count();
    }

    public static function visitsCount()
    {
        return self::all()->count();
    }

    public static function getLatestVisit()
    {
        return self::all()->last();
    }

    public function getWhenReadAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}

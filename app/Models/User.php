<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = true;

    protected $fillable = [
        'nickname',
        'phone',
        'avatar_url',
        'gender'
    ];

    protected $hidden = ['updated_at'];

    public function getCreatedAtAttribute () {
        return $this->attributes[self::CREATED_AT];
    }

    public function getUpdatedAtAttribute () {
        return $this->attributes[self::UPDATED_AT];
    }

    public function freshTimestamp()
    {
        return Carbon::now()->getPreciseTimestamp(3);
    }

    public function fromDateTime($value)
    {
        return $value;
    }

    public function getDateFormat()
    {
        return 'u';
    }
}

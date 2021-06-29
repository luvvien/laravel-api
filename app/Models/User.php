<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nickname',
        'phone',
        'avatar_url',
        'gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
//        'email_verified_at' => 'datetime',
    ];

    public function freshTimestamp()
    {
        return Carbon::now()->getPreciseTimestamp(3);
    }

    public function fromDateTime($value)
    {
        return $value;
    }

//    public function asDateTime($value)
//    {
//        return $value;
//    }

    public function getDateFormat()
    {
        return 'u';
    }
}

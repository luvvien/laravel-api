<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = [];
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

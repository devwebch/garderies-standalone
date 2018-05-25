<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    public const STATUS_UNTOUCHED    = 0;
    public const STATUS_BOOKED       = 1;
    public const STATUS_ARCHIVED     = 2;

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}

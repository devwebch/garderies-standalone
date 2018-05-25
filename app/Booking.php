<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public const STATUS_UNTOUCHED   = 0;
    public const STATUS_VALIDATED   = 1;
    public const STATUS_ARCHIVED    = 2;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function substitute()
    {
        return $this->belongsTo('App\User', 'substitute_id', 'id');
    }

    public function nursery()
    {
        return $this->belongsTo('App\Nursery');
    }
}

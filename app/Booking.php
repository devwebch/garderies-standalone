<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function nursery()
    {
        return $this->belongsTo('App\Nursery');
    }
}

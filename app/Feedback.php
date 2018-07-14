<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feedback extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function substitute()
    {
        return $this->belongsTo('App\User', 'substitute_id', 'id');
    }

    public function booking()
    {
        return $this->belongsTo('App\Booking');
    }


}

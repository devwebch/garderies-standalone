<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Nursery extends Model
{
    use SoftDeletes;

    protected $table = 'nurseries';
    protected $dates = ['deleted_at'];

    public function users()
    {
        return $this->hasMany('App\User');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking');
    }

    public function bookingRequests()
    {
        return $this->hasMany('App\BookingRequests');
    }

    public function network()
    {
        return $this->belongsTo('App\Network');
    }
}

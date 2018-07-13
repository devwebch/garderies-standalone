<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function nursery()
    {
        return $this->belongsTo('App\Nursery');
    }

    public function availabilities()
    {
        return $this->hasMany('App\Availability');
    }

    public function bookings()
    {
        return $this->hasMany('App\Booking', 'substitute_id', 'id');
    }

    public function bookingRequests()
    {
        return $this->hasMany('App\BookingRequest', 'substitute_id', 'id');
    }

    public function managedNetworks()
    {
        return $this->hasMany('App\Network');
    }

    public function networks()
    {
        return $this->belongsToMany('App\Network');
    }

    public function diploma()
    {
        return $this->belongsTo('App\Diploma');
    }

    public function workgroups()
    {
        return $this->belongsToMany('App\Workgroup');
    }
}

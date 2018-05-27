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
        return $this->hasManyThrough('App\Booking', 'App\User');
    }
}

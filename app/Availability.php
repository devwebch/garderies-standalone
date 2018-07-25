<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Availability extends Model
{
    use SoftDeletes;
    use Cachable;

    public const STATUS_UNTOUCHED    = 0;
    public const STATUS_BOOKED       = 1;
    public const STATUS_ARCHIVED     = 2;

    protected $dates = ['start', 'end', 'deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function request()
    {
        return $this->hasOne('App\BookingRequest');
    }
}

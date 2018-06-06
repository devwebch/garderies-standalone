<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    public const STATUS_PENDING     = 0;
    public const STATUS_APPROVED    = 1;
    public const STATUS_DENIED      = 2;
    public const STATUS_ARCHIVED    = 3;

    protected $dates = ['start', 'end', 'deleted_at'];

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

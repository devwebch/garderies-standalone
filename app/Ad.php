<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    public function nursery()
    {
        return $this->belongsTo('App\Nursery');
    }
}

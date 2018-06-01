<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workgroup extends Model
{
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}

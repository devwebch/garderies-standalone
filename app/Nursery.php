<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Nursery extends Model
{
    protected $table = 'nurseries';

    public function users()
    {
        return $this->hasMany('App\User');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Network extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function owner()
    {
        return $this->belongsTo('App\User', 'owner_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function nurseries()
    {
        return $this->hasMany('App\Nursery');
    }
}

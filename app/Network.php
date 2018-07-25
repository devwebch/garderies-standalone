<?php

namespace App;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Network extends Model
{
    use SoftDeletes;
    use Sluggable;

    protected $dates = ['deleted_at'];

    public function sluggable(): array
    {
        return ['slug' => ['source' => 'name']];
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }

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

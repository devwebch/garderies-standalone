<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class Availability extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['start']              = Carbon::parse($this->start)->format('d.m.Y H:i');
        $data['end']                = Carbon::parse($this->end)->format('d.m.Y H:i');
        $data['user']               = $this->user;
        $data['user']['link']       = route('users.show', $this->user->id);
        $data['nursery']            = $this->user->nursery;
        $data['nursery']['link']    = route('nurseries.show', $this->user->nursery->id);
        return $data;
    }
}

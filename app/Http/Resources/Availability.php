<?php

namespace App\Http\Resources;

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
        $data['user']       = $this->user;
        $data['user']['link']   = route('users.show', $this->user->id);
        $data['nursery']    = $this->user->nursery;
        $data['nursery']['link']    = route('nurseries.show', $this->user->nursery->id);
        return $data;
    }
}

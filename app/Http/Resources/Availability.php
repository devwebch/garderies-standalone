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
        $start  = Carbon::parse($this->start);
        $end    = Carbon::parse($this->end);

        $start_day  = $start->format('d.m.Y');
        $end_day    = $end->format('d.m.Y');
        $start_hour = $start->format('H\hi');
        $end_hour   = $end->format('H\hi');

        $data = parent::toArray($request);
        $data['matching']           = $this->matching;
        $data['start']              = $start_day;
        $data['end']                = $end_day;
        $data['start_hour']         = $start_hour;
        $data['end_hour']           = $end_hour;
        $data['user']               = $this->user;
        $data['user']['link']       = route('users.show', $this->user->id);
        $data['nursery']            = $this->user->nursery;
        $data['nursery']['link']    = route('nurseries.show', $this->user->nursery->id);
        return $data;
    }
}

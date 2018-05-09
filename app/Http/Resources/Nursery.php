<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Nursery extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'employees_count' => $this->users->count(),
            'link'  => route('nurseries.show', [$this->id])
        ];

    }
}

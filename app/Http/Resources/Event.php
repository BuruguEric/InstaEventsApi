<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Event extends JsonResource
{
     /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return[
            'event_id' => $this->event_id,
            'category' => $this->category,
            'event_name' => $this->event_name,
            'event_description' => $this->event_description,
            'event_location' => $this->event_location,
            'event_date' => $this->event_date,
            'event_host' => $this->event_host,
            'event_time' => $this->event_time,
            'event_artists' => $this->event_artists,
            'event_poster' => $this->event_poster,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class category extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'category' => $this->category,
            'category_description' => $this->category_description,
            'category_poster' => $this->category_poster,
        ];
    }
}

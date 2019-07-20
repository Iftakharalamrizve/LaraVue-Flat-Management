<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class MillCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection->transform(function ($mill){
                return [
                    'mill_status' => $mill->mill_status,
                    'second_mill' => $mill->mill_status2,
                    'user_id' => $mill->user_id,
                    'date' => $mill->date,
                ];
            })
        ];
    }
}

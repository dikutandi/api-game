<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RankResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $gamer = $this->user;

        return [
            // 'id'    => $this->id,
            'email' => $gamer->email,
            'name'  => $gamer->name,
            'score' => intval($this->count),
        ];

    }
}

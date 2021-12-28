<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
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
            'data' => $this->collection->filter(),
        ];
    }

    public function withResponse($request, $response)
    {
        $jsonResponse                     = json_decode($response->getContent(), true);
        $jsonResponse['meta']['per_page'] = intval($jsonResponse['meta']['per_page']);
        unset($jsonResponse['meta']['links']);

        $mergeResponse        = array_merge($jsonResponse['meta'], $jsonResponse['links']);
        $jsonResponse['meta'] = $mergeResponse;
        unset($jsonResponse['links']);

        $response->setContent(json_encode($jsonResponse));
    }
}

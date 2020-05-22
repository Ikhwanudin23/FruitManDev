<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            "id" => $this->id,
            "collector" => new UserResource($this->collector),
            "seller" => new UserResource($this->seller),
            "product" => new UserResource($this->product),
            "offer_price" => $this->offer_price,
            "status" => $this->status,
        ];
    }
}

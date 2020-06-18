<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            "name" => $this->name,
            "email" => $this->email,
            "image" => $this->image,
            "address" => $this->address,
            "phone" => $this->phone,
            "status" => $this->status,
            "products" => ProductResource::collection($this->products)
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\RackResource;

class VariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'name'=>$this->name,
            'color_code'=>$this->color_code,
            'volume'=>$this->volume,
            'cartoon'=>$this->cartoon,
            'price'=>$this->price,
            'unit_price'=>$this->unit_price,
            'rack_id'=>$this->rack_id,
            'rack'=>new RackResource($this->rack),
            'product_id'=>$this->product_id,
        ];
    }
}

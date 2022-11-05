<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItemResource extends JsonResource
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
            'order_id'=>$this->order_id,
            'product_id'=>$this->product_id,
            'variant_id'=>$this->variant_id,
            'variant'=>new VariantResource($this->variant),
            'quantity'=>$this->quantity,
            'volume'=>$this->volume,
            'cartoon'=>$this->cartoon,
            'total'=>$this->total,
        ];
    }
}

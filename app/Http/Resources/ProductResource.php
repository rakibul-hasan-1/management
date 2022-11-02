<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'quantity'=>$this->quantity,
            'cost'=>$this->cost,
            'supplier'=>$this->supplier,
            'godown'=>$this->godown,
            'rack'=>$this->rack
        ];
    }
}

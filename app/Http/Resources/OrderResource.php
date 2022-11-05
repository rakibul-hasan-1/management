<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'customer'=>$this->customer,
            'order_no'=>$this->order_no,
            'subtotal'=>$this->subtotal,
            'discount'=>$this->discount,
            'total'=>$this->total,
            'status'=>$this->status,
            'date'=>date('d-m-Y', strtotime($this->created_at))
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'date'=>date('d-m-Y', strtotime($this->created_at)),
            'for'=>$this->for,
            'type'=>$this->type,
            'credit'=>$this->credit,
            'debit'=>$this->debit,
            'status'=>$this->status,
            'customer'=>$this->customer,
            'supplier'=>new SupplierResource($this->supplier),
            'product'=>new ProductResource($this->product),
            'order'=>new OrderResource($this->order),
            'customer'=>$this->customer
        ];
    }
}

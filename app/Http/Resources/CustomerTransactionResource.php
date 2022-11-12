<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerTransactionResource extends JsonResource
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
            'transaction'=>$this->transaction_id,
            'invoice_id'=>$this->invoice_id,
            'type'=>$this->type,
            'total'=>$this->total,
            'paid'=>$this->paid,
            'due'=>$this->due,
            'status'=>$this->status,
            'date'=>date('d-m-Y', strtotime($this->created_at)),
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierTransactionResource extends JsonResource
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
            'transaction_id'=>$this->transaction_id,
            'transaction'=>new TransactionResource($this->transaction),
            'supplier'=>new SupplierResource($this->supplier),
            'type'=>$this->type,
            'ptotal'=>$this->previous_total,
            'total'=>$this->total,
            'paid'=>$this->paid,
            'due'=>$this->due,
            'status'=>$this->status,
            'date'=>date('d-m-Y', strtotime($this->created_at))
        ];
    }
}

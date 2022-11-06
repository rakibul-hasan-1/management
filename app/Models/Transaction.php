<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function suppliertransaction(){
        return $this->hasOne(SupplierTransaction::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function order(){
        return $this->hasMany(Order::class);
    }
    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
    public function customertransaction(){
        return $this->hasMany(CustomerTransaction::class);
    }
}

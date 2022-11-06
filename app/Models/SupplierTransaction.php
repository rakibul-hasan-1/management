<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierTransaction extends Model
{
    use HasFactory;
    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;

    public function rack(){
        return $this->belongsTo(Rack::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function orderitem(){
        return $this->hasMany(OrderItem::class);
    }
}

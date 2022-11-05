<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable=['name','cost'];

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
    public function godown(){
        return $this->belongsTo(Godown::class);
    }
    public function rack(){
        return $this->belongsTo(Rack::class);
    }
    public function variant(){
        return $this->hasMany(Variant::class);
    }
    public function orderitem(){
        return $this->hasMany(OrderItem::class);
    }
    public function transaction(){
        return $this->hasMany(Transaction::class);
    }
}

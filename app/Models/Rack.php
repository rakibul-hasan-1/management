<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rack extends Model
{
    use HasFactory;

    public function godown(){
        return $this->belongsTo(Godown::class);
    }
    public function product(){
        return $this->hasMany(Product::class);
    }
    public function variant(){
        return $this->hasMany(Variant::class);
    }
}

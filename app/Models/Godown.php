<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Godown extends Model
{
    use HasFactory;

    public function rack(){
        return $this->hasMany(Rack::class);
    }
    public function product(){
        return $this->hasMany(Product::class);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Variant;

class OrderController extends Controller
{
    public function getunitss(Request $request){
        $data=Variant::find($request->id);
        return $data;
    }
}

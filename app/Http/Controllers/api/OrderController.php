<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Variant;
use App\Models\Customer;

class OrderController extends Controller
{
    public function index(){
        $data=Order::all();
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }
    public function getvariantbycode(Request $request){
        $data=Variant::where('color_code',$request->color_code)->first();
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }
    public function searchcustomer(Request $request){
        $data=Customer::where('phone',$request->phone)->first();
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }
}

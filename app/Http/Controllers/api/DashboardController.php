<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Variant;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\Product;
use App\Http\Resources\VariantResource;
use App\Http\Resources\OrderResource;

class DashboardController extends Controller
{
    public function getstock(){
        $data=Variant::where('volume','<=',10)->orWhere('cartoon','<=',10)->paginate(20);
        return VariantResource::collection($data);
    }
    public function getrecentorder(){
        $data=Order::orderBy('id','DESC')->paginate(20);
        return OrderResource::collection($data);
    }
    public function detdashboarddetails(){
        $customer=Customer::count();
        $total_debit=Transaction::where('status','Approve')->sum('debit');
        $total_credit=Transaction::where('status','Approve')->sum('credit');
        $total_product=Product::sum('quantity');
        $total_sell=Order::sum('total');
        $order=Order::count();
        $supplier_cost=Product::sum('cost');
        return response()->json([
            'customer'=>$customer,
            'total_debit'=>$total_debit,
            'total_credit'=>$total_credit,
            'total_product'=>$total_product,
            'total_sell'=>$total_sell,
            'order'=>$order,
            'supplier_cost'=>$supplier_cost
        ]);
    }
}

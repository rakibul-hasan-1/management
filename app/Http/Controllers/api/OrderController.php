<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Variant;
use App\Models\Product;
use App\Models\Customer;
use Carbon\Carbon;
use App\Http\Resources\OrderResource;
use App\Http\Resources\VariantResource;
use App\Http\Resources\OrderItemResource;

class OrderController extends Controller
{
    public function index(){
        $data=Order::orderBy('id','DESC')->paginate(20);
        // $data=OrderResource::collection($data);
        // return response()->json([
        //     'success'=>true,
        //     'data'=>$data
        // ]);
        return OrderResource::collection($data);
    }
    public function getvariantbycode(Request $request){
        $data=Variant::where('color_code',$request->color_code)->where('status','Approved')->get();
        $data=VariantResource::collection($data);
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
    public function getunitss(Request $request){
        $data=Variant::find($request->id);
        return $data;
    }
    public function placeorder(Request $request){
        if(isset($request->customer['id'])){
            $customer_id=$request->customer['id'];
        }else{
            $customer=new Customer();
            $customer->name=$request->customer['name'];
            $customer->phone=$request->customer['phone'];
            $customer->email=$request->customer['email'];
            $customer->address=$request->customer['address'];
            $customer->status='Active';
            $customer->type='Regular';
            $customer->points="0";
            $customer->rank='Silver';
            $customer->points=10;
            $customer->save();
            $customer_id=$customer->id;
        }
        $order=new Order();
        $order->order_no=Carbon::now()->timestamp;
        $order->customer_id=$customer_id;
        $order->subtotal=$request->subtotal;
        $order->discount=$request->discount;
        $order->total=$request->total;
        $order->status="Complete";
        $order->save();

        foreach($request->variant as $key=>$oitm){
            $otm=new OrderItem();
            $otm->order_id=$order->id;
            $otm->product_id=$oitm['product_id'];
            $otm->variant_id=$oitm['id'];
            $otm->quantity=0;
            $otm->volume=$oitm['volume'] ?? 0;
            $otm->cartoon=$oitm['cartoon'] ?? 0;
            $otm->total=$oitm['price'];
            $otm->save();
            if(isset($oitm['volume'])){
                $var=Variant::find($oitm['id']);
                $newvolume=$var->volume-$oitm['volume'];
                $var->volume=$var->volume-$oitm['volume'];
                $var->price=$newvolume*$var->unit_price;
                $var->save();
            }
            if(isset($oitm['cartoon'])){
                $var=Variant::find($oitm['id']);
                $nrecartoon=$var->cartoon-$oitm['cartoon'];
                $var->cartoon=$var->cartoon-$oitm['cartoon'];
                $var->price=$nrecartoon*$var->unit_price;
                $var->save();
            }
        }
        return $order;
    }
    public function getorder(Request $request){
        $data=Order::find($request->id);
        $data=new OrderResource($data);
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }
    public function getvariantbyorder(Request $request){
        $data=OrderItem::where('order_id',$request->id)->get();
        $data=OrderItemResource::collection($data);
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }
}

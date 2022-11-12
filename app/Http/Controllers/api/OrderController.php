<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Variant;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Customer;
use App\Models\CustomerTransaction;
use Carbon\Carbon;
use App\Http\Resources\OrderResource;
use App\Http\Resources\VariantResource;
use App\Http\Resources\OrderItemResource;

class OrderController extends Controller
{
    public function index(){
        if(auth()->user()->type=='Staff'){
            $data=Order::where('user_id',auth()->user()->id)->where('manager_clearence','Pending')->orderBy('id','DESC')->paginate(20);
        }else{
            $data=Order::orderBy('id','DESC')->paginate(20);
        }
        // $data=OrderResource::collection($data);
        // return response()->json([
        //     'success'=>true,
        //     'data'=>$data
        // ]);
        return OrderResource::collection($data);
    }
    public function getvariantbycode(Request $request){
        $name=$request->name;
        $color_code=$request->color_code;
        $q = Variant::query();
        if(isset($name)){
            $q=$q->where('name','LIKE','%'.$name.'%');
        }
        if(isset($color_code)){
            $q=$q->where('color_code','LIKE','%'.$color_code.'%');
        }
        $q=$q->where('status','Approved')->get();
        // $data=Variant::where('color_code',$request->color_code)->where('status','Approved')->get();
        $data=VariantResource::collection($q);
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }
    public function searchcustomer(Request $request){
        $data=Customer::where('phone',$request->phone)->first();
        $customertransaction=CustomerTransaction::where('customer_id',$data->id)->orderBy('id','DESC')->first();
        if(isset($customertransaction)){
            $customertransaction=$customertransaction;
        }else{
            $customertransaction['invoice_id']=null;
            $customertransaction['due']=0;
        }
        return response()->json([
            'success'=>true,
            'data'=>$data,
            'transaction'=>$customertransaction
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
        $order->paid=$request->paid;
        if(isset($request->transaction['id'])){
            $order->previous_invoice_id=$request->transaction['invoice_id'];
            $order->previous_due=$request->transaction['due'];
        }else{
            $order->previous_invoice_id=null;
            $order->previous_due=0;
        }
        $order->due=$request->due;
        $order->user_id=auth()->user()->id;
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
        $transaction=new Transaction;
        $transaction->type="Credit";
        $transaction->credit=$request->paid;
        $transaction->debit=0;
        $transaction->for="Order Earn";
        $transaction->supplier_id=null;
        $transaction->customer_id=$customer_id;
        $transaction->order_id=$order->id;
        $transaction->status="Pending";
        $transaction->save();

        $customer_transaction=new CustomerTransaction();
        $customer_transaction->transaction_id=$transaction->id;
        $customer_transaction->customer_id=$customer_id;
        $customer_transaction->invoice_id=$order->order_no;
        $customer_transaction->type='Credit';
        $customer_transaction->total=$order->paid+$order->due;
        $customer_transaction->paid=$order->paid;
        $customer_transaction->due=$order->due;
        $customer_transaction->status='Approved';
        $customer_transaction->save();
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
    public function deleteorder(Request $request){
        $order=Order::find($request->id);
        $order->delete();
        return 1;
    }
}

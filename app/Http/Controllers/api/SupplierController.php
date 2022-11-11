<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\SupplierTransaction;
use App\Models\Transaction;
use App\Http\Resources\SupplierTransactionResource;
use Carbon\Carbon;


class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()){
            $data=Supplier::all();
            return response()->json([
                'success'=>true,
                'data'=>$data
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required'
        ]);
        $data=new Supplier();
        $data->name=$request->name;
        $data->phone=$request->phone;
        $data->email=$request->email;
        $data->address=$request->address;
        $data->status=$request->status;
        $data->save();
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function edits(Request $request)
    {
        $supplier=Supplier::find($request->id);
        return $supplier;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function updates(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required'
        ]);
        $data=Supplier::find($request->id);
        $data->name=$request->name;
        $data->phone=$request->phone;
        $data->email=$request->email;
        $data->address=$request->address;
        $data->status=$request->status;
        $data->save();
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }
    public function delete(Request $request)
    {
        $godown=Supplier::find($request->id);
        $godown->delete();
        return response()->json([
            'success'=>true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Supplier  $supplier
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {
        //
    }
    public function suppliertransaction(Request $request){
        $data=SupplierTransaction::where('supplier_id',$request->id)->orderBy('id','ASC')->paginate(30);
        return SupplierTransactionResource::collection($data);
    }
    public function suppliertransactionrequest(){
        $data=SupplierTransaction::where('status','Pending')->orderBy('id','DESC')->paginate(30);
        return SupplierTransactionResource::collection($data);
    }
    public function suppliertransactionapprove(Request $request){
        $data=SupplierTransaction::find($request->id);
        $olddata=SupplierTransaction::where('supplier_id',$data->supplier_id)->where('id','!=',$request->id)->where("status",'Approve')->orderBy('id','DESC')->first();
        $data->paid=$request->paid;
        if(isset($olddata)){
                $data->previous_total=$olddata->total;
            if($olddata->due > 0 ){
                $data->due=($data->total+$olddata->due)-$data->paid;
            }else{
                $data->total=$data->total+$data->paid;
            }
            if($data->total == 0){
                $data->total=$olddata->total;
            }else{
                $data->total=$data->total+$olddata->total;
            }
        }else{
            $data->previous_total=0;
            $data->due=$data->total-$data->paid;
        }        
        $data->status="Approve";
        $data->save();
        return $data;
    }
    public function createsuppliertransaction(Request $request){
        $transaction=new Transaction;
        $transaction->type="Debit";
        $transaction->credit=0;
        $transaction->debit=$request->paid;
        $transaction->for="Supplier Paid";
        $transaction->supplier_id=$request->id;
        $transaction->product_id=null;
        $transaction->status="Pending";
        $transaction->save();

        $suptran=new SupplierTransaction();
        $suptran->transaction_id=$transaction->id;
        $suptran->type="Debit";
        $suptran->supplier_id=$transaction->supplier_id;
        $suptran->paid=$request->paid;
        $suptran->status="Pending";
        $suptran->save();
        return $suptran;
    }
    public function suppliertransactionfilter(Request $request){
        if(isset($request->from)){
            $from=Carbon::parse($request->from);
        }
        if(isset($request->to)){
            $to=Carbon::parse($request->to);
        }
        $id=$request->id;

        $q = SupplierTransaction::query();
        if(isset($from) && isset($to)){
            $q=$q->whereBetween('created_at',[$from,$to]);
        }else{
            if(isset($from)){
                $q=$q->whereDate('created_at',$from);
            }
            if(isset($to)){
                $q=$q->whereDate('created_at',$to);
            }
        }
        $data = $q->where('supplier_id',$request->id)->paginate(30);
        return SupplierTransactionResource::collection($data);
    }
    public function supplierpendingtransactionfilter(Request $request){
        if(isset($request->from)){
            $from=Carbon::parse($request->from);
        }
        if(isset($request->to)){
            $to=Carbon::parse($request->to);
        }
        $id=$request->id;

        $q = SupplierTransaction::query();
        if(isset($from) && isset($to)){
            $q=$q->whereBetween('created_at',[$from,$to]);
        }else{
            if(isset($from)){
                $q=$q->whereDate('created_at',$from);
            }
            if(isset($to)){
                $q=$q->whereDate('created_at',$to);
            }
        }
        $data = $q->where('supplier_id',$request->id)->where('status','Pending')->paginate(30);
        return SupplierTransactionResource::collection($data);
    }
    public function deletesuppliertransaction(Request $request){
        $data=SupplierTransaction::find($request->id);
        $data->delete();
        return 1;
    }
}

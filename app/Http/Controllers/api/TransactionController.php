<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\SupplierTransaction;
use Carbon\Carbon;
use Auth;

class TransactionController extends Controller
{
    public function index(){
        $data=Transaction::orderBy('id','DESC')->paginate(50);
        return TransactionResource::collection($data);
    }
    public function pendingtransaction(){
        $data=Transaction::where('status','Pending')->orderBy('id','DESC')->paginate(30);
        return TransactionResource::collection($data);
    }
    public function approve(Request $request){
        $trans=Transaction::find($request->id);
        $trans->status="Approve";        
        $trans->save();
        if(isset($trans->supplier_id) && $trans->for != 'Supplier Paid'){
            $suptran=new SupplierTransaction();
            $suptran->transaction_id=$trans->id;
            $suptran->type="Debit";
            $suptran->supplier_id=$trans->supplier_id;
            $suptran->total=$trans->debit;
            $suptran->status="Pending";
            $suptran->save();
        }
        return 1;
    }
    public function delete(Request $request){
        $trans=Transaction::find($request->id);
        $trans->delete();
        return 1;
    }
    public function transactionfilter(Request $request){
        if(isset($request->from)){
            $from=Carbon::parse($request->from);
        }
        if(isset($request->to)){
            $to=Carbon::parse($request->to);
        }

        $q = Transaction::query();
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
        $data = $q->orderBy('id','DESC')->paginate(30);
        return TransactionResource::collection($data);
    }
    public function pendingtransactionfilter(Request $request){
        if(isset($request->from)){
            $from=Carbon::parse($request->from);
        }
        if(isset($request->to)){
            $to=Carbon::parse($request->to);
        }

        $q = Transaction::query();
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
        $data = $q->where('status','Pending')->orderBy('id','DESC')->paginate(30);
        return TransactionResource::collection($data);
    }
    public function createtransaction(Request $request){
        // return $request->all();
        if($request->for == null){
            return response()->json([
                'error'=>'For Required'
            ]);
        }
        $transaction=new Transaction;
        $transaction->type=$request->type;
        if($request->type=='Credit'){
            $transaction->credit=$request->amount;
            $transaction->debit=0;
        }else{
            $transaction->credit=0;
            $transaction->debit=$request->amount;
        }
        $transaction->for=$request->for;
        $transaction->user_id=auth()->user()->id;
        $transaction->status="Pending";
        $transaction->save();
        return $transaction;
    }
}

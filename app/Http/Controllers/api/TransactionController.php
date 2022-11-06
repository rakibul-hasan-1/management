<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\SupplierTransaction;

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

        if(isset($trans->supplier_id)){
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
}

<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerTransactionResource;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerTransaction;
use Carbon\Carbon;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()){
            $data=Customer::all();
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
        $data=new Customer();
        $data->name=$request->name;
        $data->phone=$request->phone;
        $data->email=$request->email;
        $data->address=$request->address;
        $data->status=$request->status;
        $data->type=$request->type;
        $data->points="0";
        $data->rank=$request->rank;
        $data->save();
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edits(Request $request)
    {
        $supplier=Customer::find($request->id);
        return $supplier;
    }
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updates(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
        ]);
        $data=Customer::find($request->id);
        $data->name=$request->name;
        $data->phone=$request->phone;
        $data->email=$request->email;
        $data->address=$request->address;
        $data->status=$request->status;
        $data->type=$request->type;
        $data->rank=$request->rank;
        $data->save();
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }
    public function delete(Request $request)
    {
        $godown=Customer::find($request->id);
        $godown->delete();
        return response()->json([
            'success'=>true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function customertransaction(){
        $data=CustomerTransaction::orderBy('id','DESC')->paginate(20);

        return response()->json([
            'success'=>true,
            'data'=>CustomerTransactionResource::collection($data),
        ]);
    }
    public function customerindividualtransaction(Request $request){
        $data=CustomerTransaction::where('customer_id',$request->id)->orderBy('id','asc')->get();

        return response()->json([
            'success'=>true,
            'data'=>CustomerTransactionResource::collection($data),
        ]);
    }
    public function customerindivudualtransactionfilter(Request $request){
        if(isset($request->from)){
            $from=Carbon::parse($request->from);
        }
        if(isset($request->to)){
            $to=Carbon::parse($request->to);
        }
        $id=$request->id;

        $q = CustomerTransaction::query();
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
        $data = $q->where('customer_id',$request->id)->orderBy('id','asc')->get();
        return response()->json([
            'success'=>true,
            'data'=>CustomerTransactionResource::collection($data),
        ]);
    }
    public function customertransactionfilter(Request $request){
        if(isset($request->from)){
            $from=Carbon::parse($request->from);
        }
        if(isset($request->to)){
            $to=Carbon::parse($request->to);
        }

        $q = CustomerTransaction::query();
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
        $data = $q->orderBy('id','asc')->get();
        return response()->json([
            'success'=>true,
            'data'=>CustomerTransactionResource::collection($data),
        ]);
    }
}

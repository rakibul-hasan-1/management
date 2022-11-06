<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\SupplierTransaction;
use App\Http\Resources\SupplierTransactionResource;


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
        $data=SupplierTransaction::where('supplier_id',$request->id)->orderBy('id','DESC')->paginate(30);
        return SupplierTransactionResource::collection($data);
    }
    public function suppliertransactionrequest(){
        $data=SupplierTransaction::where('status','Pending')->orderBy('id','DESC')->paginate(30);
        return SupplierTransactionResource::collection($data);
    }
}

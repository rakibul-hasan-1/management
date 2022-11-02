<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Rack;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()){
            $data=Product::all();
            $data=ProductResource::collection($data);
            return response()->json([
                'success'=>true,
                'data'=>$data
            ]);
        }
    }
    public function getracks(Request $request){
        $data=Rack::where('godown_id',$request->id)->get();
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }
    public function getvariant(Request $request){
        $data=Variant::where('product_id',$request->id)->get();
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
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
            'cost' => 'required',
            'quantity'=>'required'
        ]);
        $data=new Product();
        $data->name=$request->name;
        $data->quantity=$request->quantity;
        $data->supplier_id=$request->supplier_id;
        $data->godown_id=$request->godown_id;
        $data->rack_id=$request->rack_id;
        $data->cost=$request->cost;
        $data->save();
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edits(Request $request)
    {
        $supplier=Product::find($request->id);
        return $supplier;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }
    public function updates(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'cost' => 'required',
            'quantity'=>'required'
        ]);
        $data=Product::find($request->id);
        $data->name=$request->name;
        $data->quantity=$request->quantity;
        $data->supplier_id=$request->supplier_id;
        $data->godown_id=$request->godown_id;
        $data->rack_id=$request->rack_id;
        $data->cost=$request->cost;
        $data->save();
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }
    public function delete(Request $request)
    {
        $godown=Product::find($request->id);
        $godown->delete();
        return response()->json([
            'success'=>true
        ]);
    }
    public function savevariant(Request $request){
        Variant::where('product_id',$request->id)->delete();
        foreach($request->items as $key=>$item){
            if(isset($item['color_code']) && isset($item['cartoon']) && isset($item['price']) && $item['rack_id'] != 'none' && isset($item['volume'])){
            $variant=new Variant();
            $variant->name=$item['name'];
            $variant->color_code=$item['color_code'];
            $variant->cartoon=$item['cartoon'];
            $variant->price=$item['price'];
            $variant->rack_id=$item['rack_id'];
            $variant->volume=$item['volume'];
            $variant->product_id=$request->id;
            $variant->save();
            $save[]=1;
            }else{
                $save[]=null;
            }
        }
        if(count($save)>=1){
            return response()->json([
                'success'=>true
            ]);
        }else{
            return response()->json([
                'success'=>false
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}

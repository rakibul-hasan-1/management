<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Rack;
use Illuminate\Http\Request;
use App\Http\Resources\RackResource;

class RackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()){
            $data=Rack::all();
            $data=RackResource::collection($data);
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
            'godown_id' => 'required'
        ]);
        $data=new Rack();
        $data->name=$request->name;
        $data->godown_id=$request->godown_id;
        $data->save();
        $data=new RackResource($data);
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rack  $rack
     * @return \Illuminate\Http\Response
     */
    public function show(Rack $rack)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rack  $rack
     * @return \Illuminate\Http\Response
     */
    public function edits(Request $request)
    {
        $data=Rack::find($request->id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rack  $rack
     * @return \Illuminate\Http\Response
     */
    public function updates(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'godown_id' => 'required'
        ]);
        $data=Rack::find($request->id);
        $data->name=$request->name;
        $data->godown_id=$request->godown_id;
        $data->save();
        $data=new RackResource($data);
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rack  $rack
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $godown=Rack::find($request->id);
        $godown->delete();
        return response()->json([
            'success'=>true
        ]);
    }
}

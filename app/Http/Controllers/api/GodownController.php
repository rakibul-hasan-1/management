<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Godown;
use Illuminate\Http\Request;

class GodownController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()){
            $data=Godown::all();
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
            'location' => 'required'
        ]);
        $data=new Godown();
        $data->name=$request->name;
        $data->location=$request->location;
        $data->save();
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Godown  $godown
     * @return \Illuminate\Http\Response
     */
    public function show(Godown $godown)
    {
        return $godown;
    }
    public function edits(Request $request){
        $data=Godown::find($request->id);
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Godown  $godown
     * @return \Illuminate\Http\Response
     */
    public function edit(Godown $godown)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Godown  $godown
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Godown $godown)
    {
        //
    }
    public function updates(Request $request){
        $this->validate($request, [
            'name' => 'required',
            'location' => 'required'
        ]);
        $data=Godown::find($request->id);
        $data->name=$request->name;
        $data->location=$request->location;
        $data->save();
        return response()->json([
            'success'=>true,
            'data'=>$data
        ]);
    }
    public function delete(Request $request)
    {
        $godown=Godown::find($request->id);
        $godown->delete();
        return response()->json([
            'success'=>true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Godown  $godown
     * @return \Illuminate\Http\Response
     */
    public function destroy(Godown $godown)
    {
        //
    }
}

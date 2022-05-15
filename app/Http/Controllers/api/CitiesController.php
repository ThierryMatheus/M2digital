<?php

namespace App\Http\Controllers\api;

use App\Models\Cities;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = Cities::all();
        return response()->JSON($cities, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
            ['name' => 'required']
        );
        if($validator->fails()){
            $return = ['errors' => $validator->errors()];
            return response()->json($return, 400);
        }

        Cities::create($request->all());
        $return = ['message' => 'City created successfully!'];
        return response()->json($return, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cities  $cities
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cities = Cities::where('id', $id)->first();
        return response()->json($cities, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cities  $cities
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            ['name' => 'required']
        );
        if($validator->fails()){
            $return = ['errors' => $validator->errors()];
            return response()->json($return, 400);
        }

        $cities = Cities::where('id', $id)->first();
        $cities->update($request->all());
        $return = ['message' => 'City updated successfully!'];
        return response()->json($return, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cities  $cities
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cities = Cities::where('id', $id)->first();
        $cities->delete();

        $return = ['message' => 'City delete successfully'];
        return response()->json($return, 200);
    }
}

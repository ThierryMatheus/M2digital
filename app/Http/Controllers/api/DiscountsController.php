<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Discounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $discounts = Discounts::all();

        return response()->json($discounts, 200);
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
            ['value' => 'required'],
            ['product_id' => 'required']
        );
        if($validator->fails()){
            $return = ['errors' => $validator->errors()];
            return response()->json($return, 400);
        }

        Discounts::create($request->all());
        $return = ['message' => 'Discount created successfully!'];
        return response()->json($return, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Discounts  $discounts
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $discounts = Discounts::find($id);

        return response()->json($discounts, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Discounts  $discounts
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
        ['value' => 'required'],
        ['product_id' => 'required']
        );
        if($validator->fails()){
            $return = ['errors' => $validator->errors()];
            return response()->json($return, 400);
        }


        $discounts = Discounts::where('id', $id)->first();
        $discounts->update($request->all());
        $return = ['message' => 'Discount updated successfully!'];
        return response()->json($return, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discounts  $discounts
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $discounts = Discounts::where('id', $id)->first();
        $discounts->delete();

        $return = ['message' => 'Discount delete successfully'];
        return response()->json($return, 200);
    }
}

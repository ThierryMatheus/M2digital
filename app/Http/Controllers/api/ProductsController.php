<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Products::all();
        foreach ($products as $product){
            if(isset($product->discount)){
                $value = $product->price*($product->discount->value/100);
                $product->price = ($product->price-$value);
            }
        }
        return response()->json($products);
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
            ['name' => 'required'],
            ['price' => 'required']
        );
        if($validator->fails()){
            $return = ['errors' => $validator->errors()];
            return response()->json($return, 400);
        }

        Products::create($request->all());
        $return = ['message' => 'Product created successfully!'];
        return response()->json($return, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $products = Products::where('id', $id)->first();
        if(isset($products->discount)){
            $value = $products->price*(100/$products->discount);
            $products->price = $products->price - $value;
        }

        return response()->json($products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            ['name' => 'required'],
            ['price' => 'required']
        );
        if($validator->fails()){
            $return = ['errors' => $validator->errors()];
            return response()->json($return, 400);
        }

        $products=  Products::where('id',$id)->first();
        $products->update($request->all());
        $return = ['message' => 'Product created successfully!'];
        return response()->json($return, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $products = Products::where('id', $id)->first();
        $products->delete();

        $return = ['message' => 'Product delete successfully'];
        return response()->json($return, 200);
    }
}

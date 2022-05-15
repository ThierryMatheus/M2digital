<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Campaigns;
use App\Models\Groups;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CampaignsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campaigns = Campaigns::all();
        foreach ($campaigns as $campaign){
            foreach ($campaign->groups as $group){
                $campaign->groups->cities = $group->cities;
            }
            foreach ($campaign->products as $product){
                $campaign->products = $product;
                if(isset($product->discount)){
                    $value = $product->price*($product->discount->value/100);
                    $product->price = $product->price - $value;
                }
            }

        }
        return response()->json($campaigns, 200);
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
        $campaigns = new Campaigns;
        $campaigns->name = $request->name;
        $campaigns->active = 1;
        $campaigns->save();
        foreach (explode(',', $request->groups)as $id) {
            $groups = Groups::where('id', $id)->first();
            if(isset($groups)){
                $groups->campaign_id = $campaigns->id;
                $groups->save();
            }
        }
        if(isset($request->products)){
            $product = Products::find(explode(',', $request->products));
            $campaigns->products()->attach($product);
        }


        $return = ['message' => 'Campaigns created successfully!'];
        return response()->json($return, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Campaigns  $campaigns
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $campaigns = Campaigns::where('id', $id)->first();
        foreach ($campaigns->groups as $group){
            $campaigns->groups->cities = $group->cities;
        }
        return response()->json($campaigns, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Campaigns  $campaigns
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            ['name' => 'required'],
            ['groups' => 'required']
        );
        if($validator->fails()){
        $return = ['errors' => $validator->errors()];
            return response()->json($return, 400);
        }
        $campaigns = Campaigns::where('id', $id)->first();
        $groups_copy = Campaigns::where('id', $id)->first();
        $campaigns->name = $request->name;
        $campaigns->save();
        if(isset($request->groups)){
            $groups = Groups::where('campaign_id', $campaigns->id)->get();
            if(isset($groups)){
                foreach($groups as $group){
                    $group->campaign_id = null;
                    $group->save();
                }
            }
            foreach (explode(',', $request->groups)as $id) {
                $groups = Groups::where('id', $id)->first();
                if(isset($groups)){
                    $groups->campaign_id = $campaigns->id;
                    $groups->save();
                }
            }
        }
        if(isset($request->products)){
            foreach($campaigns->products as $product){
                $campaigns->products()->detach($product);
            }
            $product = Products::find(explode(',', $request->products));
            $campaigns->products()->attach($product);
        }
        $return = ['message' => 'Campaigns updated successfully!'];
        return response()->json($return, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Campaigns  $campaigns
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $campaigns = Campaigns::where('id', $id)->first();
        $campaigns->delete();

        $return = ['message' => 'Campaigns delete successfully'];
        return response()->json($return, 200);
    }
}

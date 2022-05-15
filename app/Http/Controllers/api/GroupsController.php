<?php

namespace App\Http\Controllers\api;

use App\Models\Groups;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cities;
use Illuminate\Support\Facades\Validator;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Groups::all();
        foreach ($groups as $group){
            $group->cities = $group->cities;
        }
        return response()->JSON($groups, 200);
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
        $groups = new Groups;
        $groups->name = $request->name;
        $groups->save();
        foreach (explode(',', $request->cities)as $id) {
            $cities = Cities::where('id', $id)->first();
            if(isset($cities)){
                $cities->group_id = $groups->id;
                $cities->save();
            }
        }


        $return = ['message' => 'Group created successfully!'];
        return response()->json($return, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Groups  $groups
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $groups = Groups::where('id', $id)->first();
        $groups->cities = $groups->cities;
        return response()->json($groups, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Groups  $groups
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),
            ['name' => 'required'],
            ['cities' => 'required']
        );
        if($validator->fails()){
        $return = ['errors' => $validator->errors()];
            return response()->json($return, 400);
        }
        $groups = Groups::where('id', $id)->first();
        $groups_copy = Groups::where('id', $id)->first();
        $groups->name = $request->name;
        $groups->save();
        if(isset($request->cities)){
            $cities = Cities::where('group_id', $groups->id)->get();
            if(isset($cities)){
                foreach($cities as $city){
                    $city->group_id = null;
                    $city->save();
                }
            }
            foreach (explode(',', $request->cities)as $id) {
                $cities = Cities::where('id', $id)->first();
                if(isset($cities)){
                    $cities->group_id = $groups->id;
                    $cities->save();
                }
            }
        }
        $return = ['message' => 'Group updated successfully!'];
        return response()->json($return, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Groups  $groups
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $groups = Groups::where('id', $id)->first();
        $groups->delete();

        $return = ['message' => 'Group delete successfully'];
        return response()->json($return, 200);
    }
}

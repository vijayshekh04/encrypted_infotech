<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\State;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees  = Employee::with(['state','city'])->get();

        //return $employees;
        return view('products.index',compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "name"=>"required",
            "phone"=>"required",
            "city_name"=>"required",
            "state_name"=>"required",
        ]);

       

        if ($validator->fails()){
            return response()->json(array('errors'=>$validator->errors()),422);
        }

        $input = $request->all();

        // state
        if(State::where('name',$input['state_name'])->exists())
        {
            $state =  State::where('name',$input['state_name'])->first();
            $state_id = $state->id;
            $insert_data['state_id'] = $state->id;
        }
        else
        {
            $state_id =  State::create(array("name"=>$input['state_name']))->id;
            $insert_data['state_id'] = $state_id;

        }

        // city
        if(City::where('name',$input['city_name'])->exists())
        {
            $city =  City::where('name',$input['city_name'])->first();
            $insert_data['city_id'] = $city->id;
        }
        else
        {
            
            //$state_id =  State::create(array("name"=>$input['state_name']))->id;
            $city_id =  City::create(array("name"=>$input['city_name'],"state_id"=>$state_id))->id;
            $insert_data['city_id'] = $city_id;

        }

        $insert_data['name'] = $input['name'];
        $insert_data['phone'] = $input['phone'];
    
        Employee::create($insert_data);

        return response()->json(array('status'=>"success"));
    }

    /**
     * Display the specified resource.
     */
    public function show(rc $rc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(rc $rc)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, rc $rc)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(rc $rc)
    {
        //
    }
}

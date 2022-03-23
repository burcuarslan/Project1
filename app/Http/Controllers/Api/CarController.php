<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Car::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $a=$request->user_id;
        $b=Car::where('user_id',$a)->count();
        if ($b<3){
            $car=new Car;
            $car->user_id=$request->user_id;
            $car->plaque_number=$request->plaque_number;

            $car->save();
            return response([
                'data'=>$car,
                'message'=>'Car created.',
            ]);
        }
       else{
           return response([
               'message'=>'You can have up to 3 vehicles.'
           ]);
       }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $car=User::find($id);
        if ($car) {
            return response($car,200) ;
        }
        else{
            return response(['message'=>'Car Not Found'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car=Car::find($id);

        if ($car==is_null(1)) {

            return response(['message'=>'Car Not Found', $car],404);
        }
        else{

            $car->delete();
            return response([
                'message'=>'Car Deleted',


            ],200);
        }
    }
}

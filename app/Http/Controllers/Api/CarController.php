<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use App\Models\Car;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Resource_;

class CarController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return  CarResource::collection(Car::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $car_count=$request->user_id;
        $qb=Car::where('user_id',$car_count)->count();
        if ($qb<3&$qb>0){
            $car=new Car;
            $car->user_id=$request->user_id;
            $car->plaque_number=$request->plaque_number;

            $car->save();
            return $this->apiResponse(ResultType::Success,$car,'Car created',201);
        }

       else{
           return $this->apiResponse(ResultType::Error,null,'You can have up to 3 vehicles',404);
//           return response([
//               'message'=>'You can have up to 3 vehicles.'
//           ]);
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
            return new CarResource($car);
        }
        else{
            return $this->apiResponse(ResultType::Error,null,'Car not found',404);
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
        $car->name=$request->plaque_number;

        $car->updated_at=$request->updated_at;
        $car->save();

        return $this->apiResponse(ResultType::Success,$car,'Car updated',200);
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

            return $this->apiResponse(ResultType::Error,null,'Car not found',404);
        }
        else{

            $car->delete();
            return $this->apiResponse(ResultType::Success,null,'User Deleted',200);
        }
    }
}

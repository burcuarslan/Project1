<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CarResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserWithCarsResource;
use App\Models\Car;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
//        $offset=$request->has('offset') ? $request->query('offset'):0;
//        $limit=$request->has('limit') ?  $request->query('limit'):10;

        $data=User::with('cars')->paginate(5);
       // $data=User::paginate(5);

       // $qb=User::query()->with('cars');
//        if ($request->has('q'))
//            $qb->where('name','like','%'.$request->query('q').'%');
//
//        if($request->has('sortBy'))
//            $qb->orderBy($request->query('sortBy'),$request->query('sort','DESC'));
        //$data=$qb->offset($offset)->limit($limit)->get();
        // return response(Product::offset($offset)->limit($limit)->get(),200);
        //return response($data,200);

        return UserWithCarsResource::collection($data);
        //return new UserResource($qb);


      //  return response(User::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $userFind=User::where('apartment_no',$request->apartment_no)->first();
            if ($userFind){
              return $this->apiResponse(null,'user already exists',404);
            }
            else{
                $user=new User;
                $user->name=$request->name;
                $user->surname=$request->surname;
                $user->apartment_no=$request->apartment_no;

                $user->save();

                return $this->apiResponse(ResultType::Success,$user,'user created',201);
            }

            //return new UserCollection($user);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user=User::find($id);
        if ($user) {
            //return response($user,200) ;
            return new UserResource($user);

        }
        else{
            return $this->apiResponse(ResultType::Error,null,'User not found',404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $userFind=User::find($id);

        if ($userFind==null){
            return $this->apiResponse(ResultType::Error,null,'User not found',404);
        }
        else{
           // dd();
            $userFind->name=$request->name;
            $userFind->surname=$request->surname;
            $userFind->apartment_no=$request->apartment_no;

            return $this->apiResponse(ResultType::Success,$userFind,'updated',200);
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user=User::find($id);

        if ($user==is_null(1)) {

            return $this->apiResponse(ResultType::Error,null,'User not found',404);
        }
        else{

            $user->delete();
            return $this->apiResponse(ResultType::Success,null,'User Deleted',200);

        }
    }

    public function request(Request $request, $id){
        $r=$request->get("cars");
        $user=User::find($id);

            if ($id==is_null(1)){
                $userFind=User::where('apartment_no',$request->apartment_no)->first();
                if ($userFind){
                    return $this->apiResponse(null,'user already exists',404);
                }
                else{
                    $user=new User;
                    $user->name=$request->name;
                    $user->surname=$request->surname;
                    $user->apartment_no=$request->apartment_no;
                    $user->save();
                   if ($r!=is_null(1)){
                       foreach ($request->get("cars") as $car){
                           $carNew=new Car();
                           $carNew->plaque_number=$car['plaque_number'];
                           $carNew->save();
                       }
                   }

                    return $this->apiResponse(ResultType::Success,$user,'user and car created',201);
                }
            }
            else if($request==is_null(1)&&$id!=is_null(1)){
                $user=User::find($id);

                    $user->delete();
                    return $this->apiResponse(ResultType::Success,null,'User Deleted',200);


            }
            else{
                $userFind=User::find($id);
//                if ($userFind==null){
//                    return $this->apiResponse(ResultType::Error,null,'User not found',404);
//                }

                    // dd();
                    $userFind->name=$request->name;
                    $userFind->surname=$request->surname;
                    $userFind->apartment_no=$request->apartment_no;

                //dump(@$car['id']);
                // dump($r[0]);
                foreach ($request->get("cars") as $car) {
                    Car::find($car['id'])->update([
                        'plaque_number' => $car['plaque_number']
                    ]);
                }
                return $this->apiResponse(ResultType::Success,$userFind,'updated',200);
            }


    }
}

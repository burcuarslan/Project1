<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $offset=$request->has('offset') ? $request->query('offset'):0;
        $limit=$request->has('limit') ?  $request->query('limit'):10;


        $qb=User::query()->with('cars');
        if ($request->has('q'))
            $qb->where('name','like','%'.$request->query('q').'%');

        if($request->has('sortBy'))
            $qb->orderBy($request->query('sortBy'),$request->query('sort','DESC'));
        $data=$qb->offset($offset)->limit($limit)->get();
        // return response(Product::offset($offset)->limit($limit)->get(),200);
        return response($data,200);

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
        $user=new User;
        $user->name=$request->name;
        $user->surname=$request->surname;
        $user->apartment_no=$request->apartment_no;
        $user->save();
        return response([
            'data'=>$user,
            'message'=>'User created.',
        ]);
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
            return response($user,200) ;
        }
        else{
            return response(['message'=>'User Not Found'],404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
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

            return response(['message'=>'User Not Found', $user],404);
        }
        else{

            $user->delete();
            return response([
                'message'=>'User Deleted',


            ],200);
        }
    }
}

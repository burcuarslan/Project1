<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function apiResponse($resultType,$data,$message=null,$status=200){
        $response=[];
        $response['success']=$resultType==ResultType::Success ? true:false;
        if ($resultType!=ResultType::Error)
            $response['data']=$data;
        if ($resultType==ResultType::Error)
            $response['errors']=$message;
        if(isset($message))
            $response['message']=$message;
        return response()->json($response,$status);
    }
}

class ResultType{
    const Success=1;
    const Information=2;
    const Warning=3;
    const Error=4;
}

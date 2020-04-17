<?php

namespace App\Http\Middleware;
use App\Models\User;
use Illuminate\Http\Response;

class UserAuth
{
    public function handle($request, $next)
    {

        if($request->header('token')){

            $token = $request->header('token');

            if(User::where('token', $token)->first()){
                return $next($request);
            }


        }else{

            return response()->json([
                'status'    => 'error',
                'message'   => 'Token is not presented in header'
            ], 401);

        }



    }
}

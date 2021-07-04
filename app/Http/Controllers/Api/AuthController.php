<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;


class AuthController extends Controller
{
    public function login(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $token = $user->createToken('hddbrahim')->accessToken;

            return response()->json([
                "success" => true,
                "data" => [
                    "token"=>$token,
                    "user" => new UserResource($user),
                ],
                "message" => "user login successFully"
            ]);
        }else{
            return response()->json([
                "success" => false,
                "error" => "Password or Email is incorrect"
            ]);
        }
    }
}

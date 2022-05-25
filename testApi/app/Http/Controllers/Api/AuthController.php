<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Exception;
use Illuminate\Support\Facades\Hash;

use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request){
        $creds=$request->only(['email','password']);

        if(!$token=auth()->attempt($creds)){

            return response()->json([
                'success'=>false,
                'message'=>''.$e
            ]);
        }
        return response()->json([
            'success'=>true,
            'token'=>$token,
            'user'=> Auth::user()
        ]);
    }
    public function register(Request $request){ 
        try{
            return User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]); 
            return $this->login($request);
        }catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>''.$e
            ]);
        }
    }
    public function logout(Request $request){
        try{
            echo $request;
            JWTAuth::invalidate(JWTAuth::parseToken($request->token));
            return response()->json([
                'success'=>true,
                'message'=>'logout success'
            ]);
        }catch(Exception $e){
            return response()->json([
                'success'=>false,
                'message'=>''.$e
            ]);
        }
    }

}

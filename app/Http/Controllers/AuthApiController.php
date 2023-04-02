<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthApiController extends Controller
{
    public function register(Request $request){

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
//            'password_confirmation' => 'same:password'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
//        return $user;

//        if (Auth::attempt($request->only(['email','password']))){
//            $token = Auth::user()->createToken('user_token')->plainTextToken;
//            return response()->json($token);
//        }
//        return response()->json(['message'=>'Can not register'],401);
        return response()->json([
            'message'=>'Registered',
            'success' => true
        ],200);

    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
//        return $request;
        if (Auth::attempt($request->only(['email','password']))){
            $token = Auth::user()->createToken('user_token')->plainTextToken;
            return response()->json([
                'token' => $token,
                'auth' => new UserResource(Auth::user()),
                'message'=>'login success',
                'success' => true
            ]);
        }
        return response()->json([
            'message'=>'user not found!',
            'success' => false
        ],401);
    }
    public function logout(){

        Auth::user()->currentAccessToken()->delete();
//        return response()->json(['message'=> 'successfully logout.'],204);
        return response()->json([
            'message'=>'logout!',
            'success' => true
        ]);
    }
    public function token(){
        return Auth::user()->tokens;
    }
}

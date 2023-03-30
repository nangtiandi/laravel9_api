<?php

namespace App\Http\Controllers;

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
        if (Auth::attempt($request->only(['email','password']))){
            $token = Auth::user()->createToken('user_token')->plainTextToken;
            return response()->json($token);
        }
        return response()->json(['message'=>'Can not register'],401);
    }
    public function login(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
        if (Auth::attempt($request->only(['email','password']))){
            $token = Auth::user()->createToken('user_token')->plainTextToken;
            return response()->json($token);
        }
        return response()->json(['message'=>'login error'],401);
    }
    public function logout(){
        Auth::user()->currentAccessToken()->delete();
        return response()->json(['message'=> 'successfully logout.'],204);
    }
    public function token(){
        return Auth::user()->tokens;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

//use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
        //methode pour avoir la liste des utilisateurs

    public function index()
    {
       return response()->json(User::all(), 200);
    }

    //la methode du login
    public function login(Request $request){
    	$validator = $request->only('email','password');

        if (!$token = JWTAuth::attempt($validator)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }


//methode de l'enregistrement
    public function store(Request $request)
    {
       $user= User::create(['email'=>$request->email,
       'name'=>$request->name,
       'password'=>Hash::make($request->password)]);
       return response()->json(['user'=>$user],200);
    }
//methode accessoire pour envoyer le token et les info de l'utilisateur
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user()
        ]);
    }

public function logout()
{
    auth()->logout();
    return response()->json(['message' => 'Successfully logged out']);
}

}

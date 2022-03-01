<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function index()
    {
       return response()->json(User::all(), 200);
    }


    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);

        }

        return response()->json(
            ['data'=>Auth::user(),
            'token'=>$token]
            , 200);

    }


    public function store(Request $request)
    {
       $user= User::create($request->all());
       return response()->json(['user'=>$user],200);
    }

}

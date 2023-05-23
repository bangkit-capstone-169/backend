<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public function regist(Request $request){
    $validator = Validator::make($request->all(),[
        'name' => 'required',
        'email' => 'required|unique:users',
        'password' => 'required|min:8',
    ]);


    if ($validator->fails()) {
        return response()->json($validator->errors())->setStatusCode(422);
    }
       $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'messages' => 'Register Success!',
            'token' => $token,
        ])->setStatusCode(201);
    }

    public function authenticate(Request $request)
    {
       if (! Auth::attempt($request->only('email','password'))) {
        return response()->json([
            'messages' => 'Unauthorized',
        ])->setStatusCode(401);
        }

        $user = User::where('email',$request->email)->firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;



    return response()->json([
        'messages' => 'Login Success',
        'token' => $token,
    ])->setStatusCode(200);
    
    }

    public function logout(){
        auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'messages' => 'Logout Success!'
        ])->setStatusCode(200);
    }

    public function getData(){
        $data = User::all();

        return response()->json([
            'messages' => 'Get Data Success!',
            'data' => $data
        ])->setStatusCode(200);
    }
}

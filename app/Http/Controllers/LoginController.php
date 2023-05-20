<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'messages' => 'Register Success!'
        ])->setStatusCode(201);
    }

    public function authenticate(Request $request)
    {
       if (! Auth::attempt($request->only('email','password'))) {
        return response()->json([
            'messages' => 'Unauthorized',
        ])->setStatusCode(401);
        }

    return response()->json([
        'messages' => 'Login Success',
    ])->setStatusCode(200);
    
    }
}

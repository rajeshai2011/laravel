<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Auth extends Controller
{
    public function register(Request $request){

        $request->validate(
                    ['name'=>['required'],
                    "email"=>['required','email'],
                    "password"=>['required'],

                 ]
        );
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=> Hash::make($request->password),
            ]
        );

        return response()->json([
            'token' => $user->createToken('api-token')->plainTextToken,
        ], 201);
    }

    public function login(Request $request){

        $request->validate(
                    [
                    "email"=>['required','email'],
                    "password"=>['required'],
                 ]
        );

        $user=User::where('email',$request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response()->json([
            'token' => $user->createToken('api-token')->plainTextToken,
        ]);

    }
}

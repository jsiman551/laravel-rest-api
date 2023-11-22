<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // example for authenticated routes
    public function testOauth (){
        $user = Auth::user();
        return response()->json([
            "user" => $user
        ], status: 200);
    }

    //example for public routes
    public function test (){
        return response()->json([
            "status" => "OK"
        ], status: 200);
    }

    public function register(Request $request) {

        $validator = Validator::Make($request-> all(), [
            'name' => "required",
            'email' => "required|email",
            'password' => "required",
            'confirm_password' => "required|same:password"
        ]);

        if($validator->fails()) {
            return response()->json(
                ["error"=>$validator->errors()], status: 422
            );
        }

        $input = $request->all();
        $input["password"] = bcrypt($request->get(key: "password"));
        $user = User::create($input);
        $token = $user->createToken("laravel-api")->accessToken;

        return response()->json(
            [
                "token"=>$token,
                "user"=>$user
            ],

            status: 200
        );
    }
}

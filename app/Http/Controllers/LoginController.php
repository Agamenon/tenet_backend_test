<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(LoginRequest $loginRequest){

        $user = User::where('email', $loginRequest->input('email'))->first();

        abort_if(!$user, 400, 'User does not exist');

        return DB::transaction(function () use ($loginRequest, $user) {

            if (Auth::attempt($loginRequest->only(['email', 'password']))) {

                $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;

                return response()->json(['access_token' => $token]);
            }
        });

        abort(400, 'Please make sure your email and password are correct and try again.');
    }
}

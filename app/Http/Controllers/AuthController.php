<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function store(Request $request)
    {

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        Auth::login($user);

        $token = $request->user()->createToken('invoice');

    return response()->json(['message' => 'Authorized', 'token' => $token->plainTextToken], 201);
    }

    public function login(Request $request)
    {
        if (Auth::attempt($request->only('email', 'password'))) {
            $token = $request->user()->createToken('invoice');
            return response()->json(['message' => 'Authorized', 'token' => $token->plainTextToken], 200);
        } else {
            return response()->json('Not authorized', 403);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json('token revoked', 200);
    }
}

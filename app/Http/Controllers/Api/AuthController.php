<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function login(Request $request) 
    {

        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['access_token' => $token, 'token_type' => 'Bearer']);
    }

    // method for user logout and delete token
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'You have successfully logged out and the token was successfully deleted'
        ]);
    }
}

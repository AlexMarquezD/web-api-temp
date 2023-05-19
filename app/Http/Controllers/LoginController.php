<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = User::where('email', $request['email'])->first();
            $token = $user->createToken("authToken")->plainTextToken;

            $response = [
                'access_token' => $token,
            ];

            return response()->json($response, Response::HTTP_OK);
        }

        throw ValidationException::withMessages(
            [
                'email' => ['The provided credentials are incorrect.']
            ]
        );
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json(['message' => 'logged out'], Response::HTTP_OK);
    }
}

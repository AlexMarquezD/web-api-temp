<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $user = User::all();
        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validate = $this->validateData($request);

        if ($validate->fails()) {
            return response()->json($validate->errors(), Response::HTTP_FOUND);
        }
        $data = $validate->validate();

        $user = User::create([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'email' => $data['email']
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $user = User::find($id);
        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, int $id)
    {
        User::where('id', $id)->update($request->all());
        $user = User::find($id);
        return response()->json($user, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(int $id)
    {
        User::where($id)->delete();
        return response()->json(['message' => 'user deleted'], Response::HTTP_NO_CONTENT);
    }

    /**
     * @return \Illuminate\Validation\Validator
     */
    public function validateData($request)
    {
        return Validator::make(
            $request->all(),
            [
                'name' => ['required'],
                'email' => ['required', 'email', 'unique:users'],
                'password' => ['required', 'min:6']
            ]
        );
    }
}

<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $rules = [
            'email'    => 'required|email',
            'password' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response([
                'success' => false,
                'error'   => $validator->messages()],
                400);
        }

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        } else {
            $user = User::where('email', $request['email'])->firstOrFail();

            return response([
                'success' => true,
                'user'    => new \App\Http\Resources\UserResource($user),
                'token'   => $user->createToken($user->name)->plainTextToken,
            ], 200);
        }
    }

    public function changePassword(Request $request)
    {
        $rules = [
            'password' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response([
                'success' => false,
                'error'   => $validator->messages()],
                400);
        }

        $user           = $request->user();
        $user->password = bcrypt($request->password);

        if ($user->save()) {
            return response([
                'success' => true,
                'user'    => new \App\Http\Resources\UserResource($user),
            ], 200);
        }
    }
}

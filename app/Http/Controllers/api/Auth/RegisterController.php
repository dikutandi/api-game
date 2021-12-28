<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * API Register
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function register(Request $request)
    {
        $rules = [
            'name'     => 'unique:users|required',
            'email'    => 'unique:users|required|email',
            'password' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response([
                'success' => false,
                'error'   => $validator->messages()],
                400);
        }

        $name     = $request->name;
        $email    = $request->email;
        $password = $request->password;

        $user = User::create([
            'name'     => $name,
            'email'    => $email,
            'password' => bcrypt($password)]
        );

        if ($user) {
            return response([
                'success' => true,
                'token'   => $user->createToken($user->name)->plainTextToken,
            ], 202);
        }
    }
}

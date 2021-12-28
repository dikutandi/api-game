<?php

namespace App\Http\Controllers\api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getAllUser(Request $request)
    {
        $perPage = $request->get('per_page') ?? 10;
        $users   = \App\Models\User::orderBy('name', 'ASC')
            ->paginate($perPage);

        return new \App\Http\Resources\UserCollection($users);
    }

    public function generateToken(Request $request, $id)
    {
        $user = \App\Models\User::whereId($id)->firstOrFail();

        if ($user) {
            //delete all token
            $user->tokens()->delete();

            return response([
                'success' => true,
                'token'   => $user->createToken($user->name)->plainTextToken,
            ], 202);
        }
    }

    public function getProfileById(Request $request, $id)
    {
        $user = \App\Models\User::whereId($id)->firstOrFail();
        if ($user) {
            return response([
                'success' => true,
                'user'    => new \App\Http\Resources\UserResource($user),
            ], 200);
        }
    }

    public function getProfileByToken(Request $request)
    {
        $user = $request->user();
        if ($user) {
            return response([
                'success' => true,
                'user'    => new \App\Http\Resources\UserResource($user),
            ], 200);
        }
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $rules = [
            'name'  => 'unique:users,name,' . $user->id . '|required',
            'email' => 'unique:users,email,' . $user->id . '|required|email',
            // 'password' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response([
                'success' => false,
                'error'   => $validator->messages()],
                400);
        }

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($user->save()) {
            return response([
                'success' => true,
                'user'    => new \App\Http\Resources\UserResource($user),
            ], 200);
        }
    }

}

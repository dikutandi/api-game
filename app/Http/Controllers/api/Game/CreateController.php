<?php

namespace App\Http\Controllers\api\Game;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateController extends Controller
{
    public function postGame(Request $request)
    {
        $rules = [
            'game' => 'required',
            'skor' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response([
                'success' => false,
                'error'   => $validator->messages()],
                400);
        }

        $user = $request->user();

        $newgame = \App\Models\Game::create([
            'user_id' => $user->id,
            'game'    => $request->game,
            'skor'    => $request->skor,
            'date'    => \Carbon\Carbon::today(),
        ]);

        if ($newgame) {
            //delete token
            $user->tokens()->delete();

            return response([
                'success' => true,
                'user'    => new \App\Http\Resources\UserResource($user),
            ], 202);

        } else {
            return response([
                'success' => false,
                'error'   => 'something happen',
            ], 400);
        }
    }
}

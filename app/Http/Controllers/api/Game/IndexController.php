<?php

namespace App\Http\Controllers\api\Game;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function getLeaderBoard(Request $request)
    {
        $today   = Carbon::now();
        $leaders = Game::select('user_id', 'skor')
            ->whereMonth('date', $today->month)
            ->whereYear('date', $today->year)
            ->orderBy('skor', 'DESC')
            ->limit(10)
            ->get();

        /*
        // jika satu user hanya dihitung nilai tertingginya saja
        $leaders = Game::select('user_id')
        ->selectRaw('max(skor) as skor')
        ->whereMonth('date', Carbon::today()->month)
        ->whereYear('date', Carbon::today()->year)
        ->orderBy('skor', 'DESC')
        ->groupBy('user_id')
        ->limit(10)->get();
         **/

        $ranks = Game::select('user_id')
            ->selectRaw('count(user_id) as count')
            ->whereBetween('date', [
                $today->startOfWeek()->format('Y-m-d'),
                $today->endOfWeek()->format('Y-m-d'),
            ])
            ->orderBy('count', 'DESC')
            ->groupBy('user_id')
            ->limit(10)
            ->get();

        // return $today->endOfWeek();

        $respon = [
            'leaderboard' => new \App\Http\Resources\LeaderBoardCollection($leaders),
            'most_often'  => new \App\Http\Resources\RankCollection($ranks),
        ];

        return response($respon, 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function leaderboard(User $user)
    {
        $active_leaderboard = Cache::get('leaderboard');

        if (!$active_leaderboard) {
            $leaderboard = $user->orderBy('highscore', 'desc')->take(5)->get();
            $active_leaderboard = $leaderboard->map(function ($user) {
                return [
                    'username' => $user->username,
                    'highscore' => $user->highscore,
                ];
            });
            Cache::put('leaderboard', $active_leaderboard, 120);
        }

        return $active_leaderboard->toJson();
    }
}

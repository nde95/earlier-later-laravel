<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function leaderboard(User $user)
    {
        $leaderboard = Cache::get('leaderboard');

        if (!$leaderboard) {
            $leaderboard = $user->orderBy('highscore', 'desc')->take(5)->get();
            Cache::put('leaderboard', $leaderboard, 120);
        }

        return $leaderboard->toJson();
    }
}

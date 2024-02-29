<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        return $user->all()->toJson();
    }

    public function leaderboard(User $user)
    {
        $leaderboard = $user->orderBy('highscore', 'desc')->take(5)->get();
        return $leaderboard->toJson();
    }
}

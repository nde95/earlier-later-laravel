<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    // get cached leaderboard
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

    // register new user
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required',
        ]);

        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->highscore = $request->highscore ?? 0;
        $user->save();

        return response()->json([
            'message' => 'User created successfully',
            'username' => $user->username,
            'email' => $user->email,
            'highscore' => $user->highscore,
        ], 201);
    }

    // login existing user
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        return response()->json([
            'message' => 'Login successful',
            'username' => $user->username,
            'highscore' => $user->highscore,
        ], 200);
    }

    // update high score
    public function updateHighScore(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'highscore' => 'required',
        ]);


        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

        // this is already verified on the client side, but check anyway
        if ($request->highscore <= $user->highscore) {
            return response()->json([
                'message' => 'Highscore not updated',
            ], 200);
        }

        $user->highscore = $request->highscore;
        $user->save();

        return response()->json([
            'message' => 'Highscore updated successfully',
            'username' => $user->username,
            'highscore' => $user->highscore,
        ], 200);
    }
}

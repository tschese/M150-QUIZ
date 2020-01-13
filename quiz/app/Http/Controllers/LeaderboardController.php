<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response($users);
    }

    public function addScore(Request $request)
    {
        $score = $request->get('points');
        $userId = $request->get('userId');
        $user = User::find($userId);
        $score += $user->score;
        User::whereId($userId)->update(['score' => $score]);
    }
}

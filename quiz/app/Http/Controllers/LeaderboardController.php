<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Foundation\Console\Presets\Vue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $user = DB::table('users')->where('id', $userId)->first();
        $score += $user->score;
        DB::table('users')->where('id', $userId)->update(['score' => $score]);
    }
}

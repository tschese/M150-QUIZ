<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaderboardController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response($users);
    }

    public function addScore()
    {
        $user = Auth::user();
        if ($user != null)
        {
            $newScore = 100;
            DB::table('users')->where('id', $user->id)->update(['score' => $newScore]);
        }
    }
}

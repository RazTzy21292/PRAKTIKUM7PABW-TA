<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PointController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('point.index', [
            'user' => $user,
            'levelInfo' => $user->levelInfo(),
            'leaderboard' => User::leaderboard(10)->all(),
            'activePage' => 'point',
        ]);
    }
}

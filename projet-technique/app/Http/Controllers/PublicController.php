<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function players(Request $request)
    {
        $players = Player::with('teams')
            ->when($request->search, fn ($q) =>
                $q->where('name', 'like', '%' . $request->search . '%')
            )
            ->paginate(10);

        return view('public.players.index', compact('players'));
    }

    public function player(Player $player)
    {
        return view('public.players.show', compact('player'));
    }
}


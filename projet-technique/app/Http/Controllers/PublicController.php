<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

use App\Services\PlayerService;

class PublicController extends Controller
{
    protected $playerService;

    public function __construct(PlayerService $playerService)
    {
        $this->playerService = $playerService;
    }

    public function players(Request $request)
    {
        $players = $this->playerService->search($request->all(), 5);

        return view('public.players.index', compact('players'));
    }

    public function player(Player $player)
    {
        return view('public.players.show', compact('player'));
    }
}


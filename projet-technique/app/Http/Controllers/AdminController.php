<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Services\PlayerService;

class AdminController extends Controller
{
    public function indexPlayers()
    {
        $players = Player::paginate(10);
        return view('admin.players.index', compact('players'));
    }

    public function createPlayer()
    {
        $teams = Team::all();
        return view('admin.players.create', compact('teams'));
    }

    public function storePlayer(Request $request, PlayerService $service)
    {
        $service->store($request->only(['name', 'image', 'score', 'teams']));
        return redirect()->route('admin.players')->with('success', 'Player added');
    }

    public function editPlayer(Player $player)
    {
        $teams = Team::all();
        return view('admin.players.edit', compact('player', 'teams'));
    }

    public function updatePlayer(Request $request, Player $player, PlayerService $service)
    {
        $service->update($player, $request->only(['name', 'image', 'score', 'teams']));
        return redirect()->route('admin.players')->with('success', 'Player updated');
    }

    public function deletePlayer(Player $player, PlayerService $service)
    {
        $service->delete($player);
        return back()->with('success', 'Player deleted');
    }
}
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
        $teams = Team::all()->groupBy('type');
        return view('admin.players.create', compact('teams'));
    }

    public function storePlayer(Request $request, PlayerService $service)
    {
        $request->validate([
            'name' => 'required',
            'score' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048', // Validate image file
            'teams' => 'nullable|array',
            'teams.*' => 'exists:teams,id'
        ]);

        $service->store($request->all());
        return redirect()->route('admin.players')->with('success', 'Player added');
    }

    public function editPlayer(Player $player)
    {
        $teams = Team::all()->groupBy('type');
        return view('admin.players.edit', compact('player', 'teams'));
    }

    public function updatePlayer(Request $request, Player $player, PlayerService $service)
    {
        $request->validate([
            'name' => 'required',
            'score' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048', // Validate image file
            'teams' => 'nullable|array',
            'teams.*' => 'exists:teams,id'
        ]);

        $service->update($player, $request->all());
        return redirect()->route('admin.players')->with('success', 'Player updated');
    }

    public function deletePlayer(Player $player, PlayerService $service)
    {
        $service->delete($player);
        return back()->with('success', 'Player deleted');
    }
}
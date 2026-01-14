<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Services\PlayerService;

class AdminController extends Controller
{
    protected $playerService;

    public function __construct(PlayerService $playerService)
    {
        $this->playerService = $playerService;
    }

    public function indexPlayers(Request $request)
    {
        $players = $this->playerService->search($request->all());

        if ($request->ajax()) {
            return view('admin.players.partials.table', compact('players'))->render();
        }

        $teams = Team::all()->groupBy('type');

        return view('admin.players.index', compact('players', 'teams'));
    }

    public function createPlayer()
    {
        $teams = Team::all()->groupBy('type');
        return view('admin.players.create', compact('teams'));
    }

    public function storePlayer(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'score' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048', // Validate image file
            'teams' => 'nullable|array',
            'teams.*' => 'exists:teams,id'
        ]);

        $data = $request->all();
        $user = auth()->user() ?? \App\Models\User::first();
        if (!$user) {
            $user = \App\Models\User::factory()->create();
        }
        $data['user_id'] = $user->id;

        $this->playerService->store($data);

        if ($request->ajax()) {
            return response()->json(['success' => 'Player added successfully']);
        }

        return redirect()->route('admin.players')->with('success', 'Player added');
    }

    public function editPlayer(Player $player)
    {
        $teams = Team::all()->groupBy('type');
        return view('admin.players.edit', compact('player', 'teams'));
    }

    public function updatePlayer(Request $request, Player $player)
    {
        $request->validate([
            'name' => 'required',
            'score' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048', // Validate image file
            'teams' => 'nullable|array',
            'teams.*' => 'exists:teams,id'
        ]);

        $this->playerService->update($player, $request->all());
        return redirect()->route('admin.players')->with('success', 'Player updated');
    }

    public function deletePlayer(Player $player)
    {
        $this->playerService->delete($player);

        if (request()->ajax()) {
            return response()->json(['success' => 'Player deleted successfully']);
        }

        return back()->with('success', 'Player deleted');
    }
}
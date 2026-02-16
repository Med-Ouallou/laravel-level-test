<?php

namespace App\Http\Controllers;

use App\Models\Player;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Services\PlayerService;
use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;

class AdminController extends Controller
{
    protected $playerService;

    public function __construct(PlayerService $playerService)
    {
        $this->playerService = $playerService;
    }

    public function indexPlayers(Request $request)
    {
        $players = $this->playerService->search($request->all(), 5);

        if ($request->ajax()) {
            return view('admin.players.partials.table', compact('players'))->render();
        }

        $teams = Team::all()->groupBy('type');

        return view('admin.players.index', compact('players', 'teams'));
    }

    public function createPlayer()
    {
        $this->authorize('add-players');
        $teams = Team::all()->groupBy('type');
        return view('admin.players.create', compact('teams'));
    }

    public function storePlayer(StorePlayerRequest $request, PlayerService $service)
    {
        $this->authorize('add-players');
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        $service->store($data);

        if ($request->ajax()) {
            return response()->json(['success' => 'Player added successfully']);
        }

        return redirect()->route('admin.players')->with('success', 'Player added');
    }

    public function editPlayer(Player $player)
    {
        $this->authorize('edit-players');
        $teams = Team::all()->groupBy('type');
        return view('admin.players.edit', compact('player', 'teams'));
    }

    public function updatePlayer(UpdatePlayerRequest $request, Player $player, PlayerService $service)
    {
        $this->authorize('edit-players');
        $service->update($player, $request->validated());
        return redirect()->route('admin.players')->with('success', 'Player updated');
    }

    public function deletePlayer(Player $player, PlayerService $service)
    {
        $this->authorize('delete-players');
        $service->delete($player);

        if (request()->ajax()) {
            return response()->json(['success' => 'Player deleted successfully']);
        }

        return back()->with('success', 'Player deleted');
    }
}
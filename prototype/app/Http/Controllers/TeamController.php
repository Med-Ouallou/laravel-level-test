<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Services\TeamService;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    protected $teamService;

    public function __construct(TeamService $teamService)
    {
        $this->teamService = $teamService;
    }

    public function index()
    {
        $teams = $this->teamService->getAllTeams();
        return view('admin.teams.index', compact('teams'));
    }

    public function create()
    {
        return view('admin.teams.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required', 'type' => 'nullable']);
        $this->teamService->store($request->all());
        return redirect()->route('admin.teams.index')->with('success', 'Team created');
    }

    public function edit(Team $team)
    {
        return view('admin.teams.edit', compact('team'));
    }

    public function update(Request $request, Team $team)
    {
        $request->validate(['name' => 'required', 'type' => 'nullable']);
        $this->teamService->update($team, $request->all());
        return redirect()->route('admin.teams.index')->with('success', 'Team updated');
    }

    public function destroy(Team $team)
    {
        $this->teamService->delete($team);
        return redirect()->route('admin.teams.index')->with('success', 'Team deleted');
    }
}

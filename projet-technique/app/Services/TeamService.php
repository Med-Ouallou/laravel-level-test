<?php

namespace App\Services;

use App\Models\Team;

class TeamService
{
    public function getAllTeams()
    {
        return Team::all();
    }

    public function store(array $data)
    {
        return Team::create($data);
    }


    public function update(Team $team, array $data)
    {
        $team->update($data);
        return $team;
    }

    public function delete(Team $team)
    {
        $team->delete();
    }
}

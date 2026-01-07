<?php
namespace App\Services;
use App\Models\Team;

class TeamService
{
    public function store(array $data)
    {
        return Team::create($data);
    }

    public function delete(Team $team)
    {
        $team->delete();
    }
}

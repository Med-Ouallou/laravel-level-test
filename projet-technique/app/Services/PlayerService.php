<?php

namespace App\Services;
use App\Models\Player;

class PlayerService
{
    public function store(array $data)
    {
        $player = Player::create($data);
        if (isset($data['teams'])) {
            $player->teams()->sync($data['teams']);
        }
        return $player;
    }

    public function update(Player $player, array $data)
    {
        $player->update($data);
        if (isset($data['teams'])) {
            $player->teams()->sync($data['teams']);
        }
        return $player;
    }

    public function delete(Player $player)
    {
        $player->delete();
    }
}

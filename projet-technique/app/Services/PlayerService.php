<?php

namespace App\Services;
use App\Models\Player;

class PlayerService
{
    public function store(array $data)
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $data['image']->store('players', 'public');
            $data['image'] = '/storage/' . $path;
        }

        $player = Player::create($data);
        if (isset($data['teams'])) {
            $player->teams()->sync($data['teams']);
        }
        return $player;
    }

    public function update(Player $player, array $data)
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $data['image']->store('players', 'public');
            $data['image'] = '/storage/' . $path;
        }

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

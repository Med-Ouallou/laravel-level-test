<?php

namespace App\Services;

use App\Models\Player;
use Illuminate\Support\Facades\Storage;

class PlayerService
{
    public function store(array $data): Player
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = $data['image']->store('players', 'public');
        }

        $player = Player::create($data);

        if (isset($data['teams'])) {
            $player->teams()->sync($data['teams']);
        }

        return $player;
    }

    public function update(Player $player, array $data): Player
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($player->image) {
                Storage::disk('public')->delete($player->image);
            }
            $data['image'] = $data['image']->store('players', 'public');
        }

        $player->update($data);

        if (isset($data['teams'])) {
            $player->teams()->sync($data['teams']);
        }

        return $player;
    }

    public function delete(Player $player): void
    {
        if ($player->image) {
            Storage::disk('public')->delete($player->image);
        }
        $player->delete();
    }

    public function search(array $filters = [], int $perPage = 10)
    {
        $query = Player::with('teams');

        if (isset($filters['search']) && $filters['search'] != '') {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        if (isset($filters['team_id'])) {
            $query->whereHas('teams', function ($q) use ($filters) {
                $q->where('teams.id', $filters['team_id']);
            });
        }

        return $query->paginate($perPage);
    }
    
    public function getAll(array $filters = [], int $perPage = 10)
    {
        return $this->search($filters, $perPage);
    }
}

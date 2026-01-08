<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = ['image', 'name', 'score', 'user_id', 'team'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function teams() {
        return $this->belongsToMany(Team::class, 'player_team');
    }
}


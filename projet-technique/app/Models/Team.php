<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = ['name', 'user_id', 'type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function players()
    {
        return $this->belongsToMany(Player::class, 'player_team');
    }
}

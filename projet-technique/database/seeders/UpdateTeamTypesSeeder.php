<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class UpdateTeamTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update teams that likely represent countries (based on name or previous logic)
        // Here we can simply set odd IDs to Club and even IDs to Country for demonstration
        $teams = Team::all();
        foreach ($teams as $team) {
            $type = ($team->id % 2 == 0) ? 'country' : 'club';
            $team->update(['type' => $type]);
        }
    }
}

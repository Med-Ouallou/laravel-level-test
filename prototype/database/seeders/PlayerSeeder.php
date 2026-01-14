<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Player;
use App\Models\User;
class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // CSV Path
        $file = database_path('Data/players.csv');

        // Read CSV
        $rows = array_map('str_getcsv', file($file));
        $header = array_shift($rows); 

        foreach ($rows as $row) {
            if(count($row) < 5) continue; 
            $data = array_combine($header, $row);
            
            $teamNames = explode('|', $data['team'] ?? '');
            
            // Remove 'team' from data as it's not a column in players table
            unset($data['team']);

            // Ensure valid user_id
            $user = User::find($data['user_id']);
            if (!$user) {
                $data['user_id'] = User::first()->id ?? User::factory()->create()->id;
            }

            $player = Player::updateOrCreate(['name' => $data['name']], $data);
            
            if (!empty($teamNames)) {
                $teamIds = \App\Models\Team::whereIn('name', array_map('trim', $teamNames))->pluck('id')->toArray();
                $player->teams()->sync($teamIds);
            }
        }
    }
}

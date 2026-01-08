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
            if(count($row) < 4) continue; 
            $data = array_combine($header, $row);
            Player::updateOrCreate(['name' => $data['name']], $data);
        }
    }
}

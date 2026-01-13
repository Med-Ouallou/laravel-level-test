<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing teams
        Team::query()->delete();

        $file = database_path('data/team.csv');

        if (!file_exists($file)) {
            return;
        }

        $rows = array_map('str_getcsv', file($file));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            if (empty($row)) continue;
            
            $data = array_combine($header, $row);
            
            // Simple inference for type, defaults to 'club' if not a country
            $countries = ['Brazil', 'Argentine', 'Portugal', 'France', 'Spain', 'Germany'];
            $type = in_array($data['name'], $countries) ? 'country' : 'club';

            Team::updateOrCreate(
                ['name' => $data['name']],
                ['type' => $type]
            );
        }
    }
}

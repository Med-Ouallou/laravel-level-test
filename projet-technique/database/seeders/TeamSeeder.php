<?php

namespace Database\Seeders;

use App\Models\User;    
use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds. 
     */
    public function run(): void
    {
        $file = database_path('Data/teams.csv');

        $rows = array_map('str_getcsv', file($file));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            if(count($row) < 2) continue;
            Team::create(array_combine($header, $row));
        }
    }
}

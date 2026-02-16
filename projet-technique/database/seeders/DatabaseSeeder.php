<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RolesAndPermissions::class,
            UserSeeder::class,
            PlayerSeeder::class,
            TeamSeeder::class,
        ]);
    }
}
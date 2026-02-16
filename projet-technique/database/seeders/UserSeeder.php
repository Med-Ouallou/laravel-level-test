<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = database_path('data/user.csv');

        $rows = array_map('str_getcsv', file($file));
        $header = array_shift($rows);

        foreach ($rows as $row) {
            if (count($row) < 3)
                continue;

            $data = array_combine($header, $row);

            // Hash password if it's plain text (simple check or always hash in seeder)
            $data['password'] = \Illuminate\Support\Facades\Hash::make($data['password']);

            $user = User::updateOrCreate(['email' => $data['email']], [
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            // Assign role using Spatie
            $roleName = ($user->name === 'Anouar') ? 'admin' : 'editor';
            $user->assignRole($roleName);
        }
    }
}
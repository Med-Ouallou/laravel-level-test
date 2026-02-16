<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'access-admin']);
        Permission::create(['name' => 'add-players']);
        Permission::create(['name' => 'edit-players']);
        Permission::create(['name' => 'delete-players']);

        // Create roles and assign created permissions
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo(Permission::all());

        $roleEditor = Role::create(['name' => 'editor']);
        $roleEditor->givePermissionTo(['access-admin', 'add-players', 'edit-players']);
    }
}

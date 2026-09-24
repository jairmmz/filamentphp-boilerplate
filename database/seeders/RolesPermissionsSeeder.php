<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $superAdmin = Role::create(['name' => 'Super Admin']);

        $this->command->info('Generando permisos de Shield...');
        $this->command->call('shield:generate', [
            '--all' => true,
            '--option' => 'permissions',
            '--panel' => 'admin',
        ]);

        $superAdmin->givePermissionTo(Permission::all());

        $adminUser = User::query()->first();

        $adminUser->assignRole('Super Admin');

        $this->command->info('Roles y permisos creados exitosamente.');
    }
}

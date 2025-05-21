<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        Permission::create(['name' => 'view appointment']);
        
        Permission::create(['name' => 'view staff']);
        Permission::create(['name' => 'create staff']);
        Permission::create(['name' => 'edit staff']);
        Permission::create(['name' => 'delete staff']);

        Permission::create(['name' => 'view masterdata']);
        Permission::create(['name' => 'create masterdata']);
        Permission::create(['name' => 'edit masterdata']);
        Permission::create(['name' => 'delete masterdata']);

        // Create roles and assign existing permissions
        $role = Role::create(['name' => 'super admin']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'doctor']);
        $role->givePermissionTo('view appointment');

        $role = Role::create(['name' => 'normal user']);
        $role->givePermissionTo('view appointment');

        // Assign roles to users
        // $user = User::find(3); // Assuming the user with ID 1 exists
        // if ($user) {
        //     $user->assignRole('super admin');
        // }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $subAdminRole = Role::create(['name' => 'sub_admin']);
        Role::create(['name' => 'employee']);

        $tasksCrudPermissions[] = Permission::create(['name' => 'create task']);
        $tasksCrudPermissions[] = Permission::create(['name' => 'read task']);
        $tasksUpdatePermissions[] = Permission::create(['name' => 'update task']);
        $tasksCrudPermissions[] = Permission::create(['name' => 'delete task']);

        $assignTaskPermission = Permission::create(['name' => 'assign task']);
        $revokeTaskPermission = Permission::create(['name' => 'revoke task']);

        $usersCrudPermissions[] = Permission::create(['name' => 'create user']);
        $usersCrudPermissions[] = Permission::create(['name' => 'read user']);
        $usersCrudPermissions[] = Permission::create(['name' => 'update user']);
        $usersCrudPermissions[] = Permission::create(['name' => 'delete user']);


        $adminRole->syncPermissions([
            $tasksCrudPermissions,
            $assignTaskPermission,
            $revokeTaskPermission,
            $tasksUpdatePermissions,
            ...$usersCrudPermissions,
        ]);

        $subAdminRole->syncPermissions([
            $tasksUpdatePermissions,
            $assignTaskPermission,
            $revokeTaskPermission
        ]);
    }
}

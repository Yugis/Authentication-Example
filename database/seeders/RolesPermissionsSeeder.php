<?php

namespace Database\Seeders;

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
        Role::create(['name' => 'super admin']);
        $employeeRole = Role::create(['name' => 'employee']);
        $adminRole = Role::create(['name' => 'admin']);

        $tasksCrudPermissions[] = Permission::create(['name' => 'create task']);
        $tasksCrudPermissions[] = Permission::create(['name' => 'read task']);
        $tasksUpdatePermissions[] = Permission::create(['name' => 'update task']);
        $tasksCrudPermissions[] = Permission::create(['name' => 'delete task']);
        $updateTaskStatusPermission[] = Permission::create(['name' => 'update task status']);

        $assignTaskPermission = Permission::create(['name' => 'assign task']);
        $revokeTaskPermission = Permission::create(['name' => 'revoke task']);

        $usersCrudPermissions[] = Permission::create(['name' => 'create user']);
        $usersCrudPermissions[] = Permission::create(['name' => 'read user']);
        $usersCrudPermissions[] = Permission::create(['name' => 'update user']);
        $usersCrudPermissions[] = Permission::create(['name' => 'delete user']);


        $adminRole->syncPermissions([
            $tasksUpdatePermissions,
            $assignTaskPermission,
            $revokeTaskPermission,
            $updateTaskStatusPermission
        ]);

        $employeeRole->syncPermissions([
            $tasksCrudPermissions,
            $tasksUpdatePermissions,
            $updateTaskStatusPermission
        ]);
    }
}

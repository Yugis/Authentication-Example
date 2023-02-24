<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        tap(
            User::factory()->create([
                'name' => 'Super Admin',
                'email' => 'superadmin@e.com',
                'department_id' => null
            ]),
            function ($admin) {
                $admin->assignRole('super admin');
            }
        );

        tap(
            User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin@e.com',
                'department_id' => null
            ]),
            function ($admin) {
                $admin->assignRole('admin');
            }
        );


        tap(User::factory(10)->create(), function ($users) {
            $users->each->assignRole('employee');
        });
    }
}

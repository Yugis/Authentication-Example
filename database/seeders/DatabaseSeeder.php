<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Department;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Department::factory()->create(['name' => 'HR']);
        Department::factory()->create(['name' => 'IT']);
        Department::factory()->create(['name' => 'Marketing']);

        $this->call([
            RolesPermissionsSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Task::factory(50)->create();

        tap(User::factory(10)->create(), function ($users) {
            $users->each->assignRole('employee');
        });
    }
}

<?php

namespace Database\Seeders;

use App\Models\Unit;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Position;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)
            ->has(Position::factory()->count(3))
            ->for(Unit::factory())
            ->create();

        User::factory()
            ->has(Position::factory()->count(3))
            ->create([
                'name' => 'Admin',
                'email' => 'mail@mail.com',
                'username' => 'admin',
                'password' => bcrypt('password'),
            ]);
    }
}

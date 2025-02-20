<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\LoginHistory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LoginHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LoginHistory::factory()
            ->count(1000)
            ->create([
                'user_id' => function () {
                    return User::inRandomOrder()->value('id');
                }
            ]);
    }
}

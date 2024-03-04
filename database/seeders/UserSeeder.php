<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Domain\Models\Users\UserStatus;
use App\Models\User;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create();

        // Test User
        User::factory()->create([
            'original_id' => 'test_user',
            'password' => bcrypt('test_password'),
            'status' => UserStatus::ACTIVE,
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'tel' => '123-456-7890',
            'birthday' => '2000-01-01',
            'last_login' => now(),
        ]);
        // Developer User
        User::factory()->create([
            'original_id' => 'dev_user',
            'password' => bcrypt('dev_password'),
            'status' => UserStatus::DEVELOPER,
            'first_name' => 'Developer',
            'last_name' => 'User',
            'email' => 'developer@example.com',
            'tel' => '098-765-4321',
            'birthday' => '1990-01-01',
            'last_login' => now(),
        ]);
    }
}

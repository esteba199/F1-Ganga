<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Brand;
use App\Models\Team;
use App\Models\Car;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin & Users
        $this->command->info('Seeding Users...');
        $admin = User::updateOrCreate(
            ['email' => 'admin@f1ganga.com'],
            [
                'name' => 'Admin Misael',
                'password' => Hash::make('admin123'),
                'is_admin' => true,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'carlos@f1ganga.com'],
            [
                'name' => 'Carlos Sainz Jr',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        User::factory()->count(10)->create();

        // 2. Core Entities (Brands, Teams, Cars)
        $this->command->info('Seeding Brands, Teams and Cars...');
        $this->call([
            BrandSeeder::class,
            TeamSeeder::class,
            CarSeeder::class,
        ]);

        // 3. Transactions (Orders, Items, Transactions)
        $this->command->info('Seeding Orders and Transactions...');
        $this->call([
            OrderSeeder::class,
            ReviewSeeder::class,
        ]);

        $this->command->info('Database seeding completed successfully!');
    }
}

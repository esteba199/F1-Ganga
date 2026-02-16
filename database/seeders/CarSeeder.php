<?php

namespace Database\Seeders;

use App\Models\Car;
use App\Models\Brand;
use App\Models\Team;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $brands = Brand::all();
        $teams = Team::all();

        if ($brands->isEmpty() || $teams->isEmpty()) {
            $this->command->info('Creating brands and teams first...');
            Brand::factory()->count(10)->create();
            Team::factory()->count(10)->create();
            $brands = Brand::all();
            $teams = Team::all();
        }

        Car::factory()->count(50)->create([
            'brand_id' => fn() => $brands->random()->id,
            'team_id' => fn() => $teams->random()->id,
        ]);
    }
}

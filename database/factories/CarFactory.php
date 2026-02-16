<?php

namespace Database\Factories;

use App\Models\Car;
use App\Models\Brand;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarFactory extends Factory
{
    protected $model = Car::class;

    public function definition(): array
    {
        $models = ['SF-24', 'W15', 'RB20', 'MCL60', 'AMR24', 'A524', 'FW46', 'VF-24', 'C44', 'V-ARB 01'];
        
        return [
            'model' => $this->faker->randomElement($models) . ' ' . $this->faker->bothify('??-###'),
            'brand_id' => Brand::factory(),
            'team_id' => Team::factory(),
            'price' => $this->faker->numberBetween(5000000, 15000000),
            'year' => $this->faker->numberBetween(2020, 2024),
            'description' => $this->faker->paragraph(),
            'image_url' => 'https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7?w=800&h=600&fit=crop',
            'top_speed' => $this->faker->numberBetween(330, 360),
            'acceleration' => $this->faker->randomFloat(1, 2, 3),
            'engine' => $this->faker->randomElement(['V6 Turbo Hybrid 1.6L', 'Honda RBPT V6', 'Mercedes V6', 'Ferrari V6']),
            'horsepower' => $this->faker->numberBetween(1000, 1100),
            'transmission' => '8-speed semi-automatic',
        ];
    }
}

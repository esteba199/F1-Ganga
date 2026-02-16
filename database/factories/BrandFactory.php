<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        $brands = [
            ['name' => 'Ferrari', 'country' => 'Italy'],
            ['name' => 'Mercedes', 'country' => 'Germany'],
            ['name' => 'Red Bull', 'country' => 'Austria'],
            ['name' => 'McLaren', 'country' => 'United Kingdom'],
            ['name' => 'Aston Martin', 'country' => 'United Kingdom'],
            ['name' => 'Alpine', 'country' => 'France'],
            ['name' => 'Williams', 'country' => 'United Kingdom'],
            ['name' => 'Haas', 'country' => 'United States'],
            ['name' => 'Sauber', 'country' => 'Switzerland'],
            ['name' => 'VCARB', 'country' => 'Italy'],
        ];

        $brand = $this->faker->unique()->randomElement($brands);

        return [
            'name' => $brand['name'],
            'country' => $brand['country'],
        ];
    }
}

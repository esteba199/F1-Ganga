<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use App\Models\Car;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        $car = Car::first();

        if ($user && $car) {
            Review::create([
                'user_id' => $user->id,
                'car_id' => $car->id,
                'rating' => 5,
                'comment' => 'Increíble potencia y manejo. El coche de mis sueños.',
            ]);

            Review::create([
                'user_id' => $user->id,
                'car_id' => $car->id,
                'rating' => 4,
                'comment' => 'Muy bueno, aunque el consumo es elevado.',
            ]);
        }
    }
}

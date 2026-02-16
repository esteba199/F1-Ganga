<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\Order;
use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    protected $model = OrderItem::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'car_id' => Car::factory(),
            'price' => $this->faker->numberBetween(5000000, 15000000),
            'quantity' => $this->faker->numberBetween(1, 1), // Usually 1 for cars, but schema supports more
        ];
    }
}

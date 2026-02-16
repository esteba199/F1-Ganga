<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'paypal_transaction_id' => $this->faker->unique()->bothify('TXN-##########'),
            'amount' => $this->faker->numberBetween(5000000, 30000000),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed', 'refunded']),
            'payment_method' => 'paypal',
            'payment_details' => json_encode([
                'payer' => $this->faker->name(),
                'email' => $this->faker->email(),
                'timestamp' => now()->toISOString(),
            ]),
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Car;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('is_admin', false)->get();
        $cars = Car::all();

        if ($users->isEmpty()) {
            User::factory()->count(5)->create();
            $users = User::where('is_admin', false)->get();
        }

        if ($cars->isEmpty()) {
            return;
        }

        Order::factory()->count(20)->create([
            'user_id' => fn() => $users->random()->id,
        ])->each(function ($order) use ($cars) {
            // Add 1-3 items per order
            $orderCars = $cars->random(rand(1, 3));
            $total = 0;

            foreach ($orderCars as $car) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'car_id' => $car->id,
                    'price' => $car->price,
                    'quantity' => 1,
                ]);
                $total += $car->price;
            }

            $order->update(['total' => $total]);

            // Create a transaction for most orders
            if (rand(0, 10) > 2) {
                Transaction::create([
                    'order_id' => $order->id,
                    'paypal_transaction_id' => 'TXN-' . strtoupper(bin2hex(random_bytes(5))),
                    'amount' => $total,
                    'status' => $order->status === 'paid' || $order->status === 'completed' ? 'completed' : 'pending',
                    'payment_method' => 'paypal',
                    'payment_details' => json_encode(['mock' => true])
                ]);
            }
        });
    }
}

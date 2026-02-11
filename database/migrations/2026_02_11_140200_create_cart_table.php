<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cart', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->timestamps();
            
            // Usuario solo puede tener un coche una vez en el carrito
            $table->unique(['user_id', 'car_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart');
    }
};

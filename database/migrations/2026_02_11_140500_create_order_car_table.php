<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pivot table para relación N:M entre Order y Car
        Schema::create('order_car', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 12, 2); // Precio en el momento de la compra
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_car');
    }
};

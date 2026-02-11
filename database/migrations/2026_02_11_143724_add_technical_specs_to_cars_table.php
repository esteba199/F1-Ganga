<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->integer('top_speed')->nullable()->comment('Velocidad máxima en km/h');
            $table->decimal('acceleration', 3, 1)->nullable()->comment('0-100 km/h en segundos');
            $table->string('engine')->nullable()->comment('Tipo de motor');
            $table->integer('horsepower')->nullable()->comment('Caballos de fuerza');
            $table->string('transmission')->nullable()->comment('Tipo de transmisión');
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropColumn(['top_speed', 'acceleration', 'engine', 'horsepower', 'transmission']);
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country')->nullable();
            $table->timestamps();
        });

        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('principal')->nullable();
            $table->timestamps();
        });

        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('model');
            $table->foreignId('brand_id')->constrained();
            $table->foreignId('team_id')->constrained();
            $table->decimal('price', 15, 2);
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->integer('year');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cars');
        Schema::dropIfExists('teams');
        Schema::dropIfExists('brands');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->foreignId('car_condition_id')->nullable()->after('team_id')->constrained('car_conditions')->onDelete('set null');
            $table->foreignId('car_model_id')->nullable()->after('brand_id')->constrained('car_models')->onDelete('set null');
            $table->integer('quantity')->default(1)->after('price');
        });
    }

    public function down(): void
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropForeign(['car_condition_id']);
            $table->dropForeign(['car_model_id']);
            $table->dropColumn(['car_condition_id', 'car_model_id', 'quantity']);
        });
    }
};

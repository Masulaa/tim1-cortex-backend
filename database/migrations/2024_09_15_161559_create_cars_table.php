<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->string('make')->index();
            $table->string('model');
            $table->integer('year');
            $table->string('transmission');
            $table->string('fuel_type');
            $table->integer('doors');
            $table->decimal('price_per_day', 8, 2);
            $table->boolean('availability')->default(true)->index();
            $table->string('status')->default('available'); // Status (available, in use)
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};

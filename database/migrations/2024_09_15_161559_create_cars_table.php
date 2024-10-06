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
            $table->string('model')->index();
            $table->integer('year');
            $table->string('transmission');
            $table->string('fuel_type');
            $table->integer('doors');
            $table->integer('price_per_day');
            $table->string('status')->default('available'); // available, reserved, under maintenance, out of order
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

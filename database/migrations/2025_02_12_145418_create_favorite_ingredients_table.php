<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('favorite_ingredients', function (Blueprint $table) {
            $table->string('uuid', 36)->primary();
            $table->string('user_uuid', 36);
            $table->string('ingredient_uuid', 36);
            $table->timestamps();

            $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');
            $table->foreign('ingredient_uuid')->references('uuid')->on('ingredients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_ingredients');
    }
};

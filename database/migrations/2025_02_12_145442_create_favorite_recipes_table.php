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
        Schema::create('favorite_recipes', function (Blueprint $table) {
            $table->string('uuid', 36)->primary();
            $table->string('user_uuid', 36);
            $table->string('recipe_uuid', 36);
            $table->timestamps();

            $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');
            $table->foreign('recipe_uuid')->references('uuid')->on('recipes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorite_recipes');
    }
};

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
        Schema::create('recipe_steps', function (Blueprint $table) {
            $table->string('uuid', 36)->primary();
            $table->string('recipe_uuid', 36);
            $table->integer('step_number');
            $table->text('description');
            $table->timestamps();

            $table->foreign('recipe_uuid')->references('uuid')->on('recipes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_steps');
    }
};

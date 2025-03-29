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
        Schema::create('recipes', function (Blueprint $table) {
            $table->string('uuid', 36)->primary();
            $table->string('user_uuid', 36);
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->integer('favorite_count')->default(0); // お気に入りの累計数
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipes');
    }
};

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
        Schema::create('ingredients_categories', function (Blueprint $table) {
            $table->uuid('uuid')->primary();
            $table->uuid('ingredient_uuid');
            $table->uuid('i_category_uuid');
            $table->timestamps();

            // 外部キー制約（この時点では ingredient_uuid のみ）
            $table->foreign('ingredient_uuid')->references('uuid')->on('ingredients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredients_categories');
    }
};

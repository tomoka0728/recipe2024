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
        Schema::create('recipe_categories', function (Blueprint $table) {
            $table->string('uuid', 36)->primary();
            $table->string('recipe_uuid', 36);
            $table->string('category_uuid', 36);
            $table->timestamps();

            $table->foreign('recipe_uuid')->references('uuid')->on('recipes')->onDelete('cascade');
            // 外部キー制約は後で追加（カラムリネーム後）
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_categories');
    }
};

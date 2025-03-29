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
        Schema::table('recipes', function (Blueprint $table) {
            $table->integer('cooking_time')->after('image_path'); // 所要時間（分単位）
            $table->integer('servings')->after('cooking_time'); // 何人前
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipes', function (Blueprint $table) {
            $table->dropColumn('cooking_time');
            $table->dropColumn('servings');
        });
    }
};

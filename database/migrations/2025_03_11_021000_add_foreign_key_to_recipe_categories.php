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
        Schema::table('recipe_categories', function (Blueprint $table) {
            // リネーム後のカラムに外部キーを追加
            $table->foreign('r_category_uuid')
                ->references('uuid')
                ->on('r_categories')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('recipe_categories', function (Blueprint $table) {
            $table->dropForeign(['r_category_uuid']);
        });
    }
};

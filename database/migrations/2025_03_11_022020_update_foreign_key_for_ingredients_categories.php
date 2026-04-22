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
        Schema::table('ingredients_categories', function (Blueprint $table) {
            // i_category_uuid の外部キーを追加
            $table->foreign('i_category_uuid')
                  ->references('uuid')
                  ->on('i_categories')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingredients_categories', function (Blueprint $table) {
            // 外部キーを削除
            $table->dropForeign(['i_category_uuid']);
        });
    }
};

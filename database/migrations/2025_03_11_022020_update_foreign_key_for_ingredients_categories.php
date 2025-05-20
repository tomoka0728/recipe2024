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
            // 既存の外部キーを削除
            $table->dropForeign('ingredients_categories_i_category_uuid_foreign');
            $table->dropForeign('recipe_categories_recipe_uuid_foreign_copy');

            // 新しい外部キーを設定
            $table->foreign('i_category_uuid')
                  ->references('uuid')
                  ->on('i_categories')  // 🔄 正しいテーブルに変更
                  ->onDelete('cascade');

            $table->foreign('ingredient_uuid')
                  ->references('uuid')
                  ->on('ingredients')  // 🔄 正しいテーブルに変更
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingredients_categories', function (Blueprint $table) {
            // 新しい外部キーを削除
            $table->dropForeign(['i_category_uuid']);
            $table->dropForeign(['ingredient_uuid']);

            // 元の外部キーを復元（もし必要なら）
            $table->foreign('i_category_uuid')
                  ->references('uuid')
                  ->on('r_categories')
                  ->onDelete('cascade');

            $table->foreign('ingredient_uuid')
                  ->references('uuid')
                  ->on('recipes')
                  ->onDelete('cascade')
                  ->onUpdate('restrict');
        });
    }
};

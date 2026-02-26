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
        Schema::table('saved_items', function (Blueprint $table) {
            // item_typeとitem_uuidを追加（ポリモーフィック）
            $table->string('item_type')->after('user_uuid')->nullable();
            $table->uuid('item_uuid')->after('item_type')->nullable();

            // quantityは食材専用なのでnullable化
            $table->integer('quantity')->nullable()->change();

            // ingredient_uuidもnullable化（レシピの場合は使わない）
            $table->uuid('ingredient_uuid')->nullable()->change();
        });

        // 既存データをマイグレーション（ingredient → item）
        DB::statement("UPDATE saved_items SET item_type = 'App\\\\Models\\\\Ingredient', item_uuid = ingredient_uuid WHERE ingredient_uuid IS NOT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('saved_items', function (Blueprint $table) {
            $table->dropColumn(['item_type', 'item_uuid']);
            $table->integer('quantity')->nullable(false)->change();
        });
    }
};

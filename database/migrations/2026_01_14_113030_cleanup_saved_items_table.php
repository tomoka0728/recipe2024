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
            // 外部キー制約を削除
            $table->dropForeign(['ingredient_uuid']);

            // 不要なカラムを削除
            $table->dropColumn(['ingredient_uuid', 'quantity']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('saved_items', function (Blueprint $table) {
            // カラムを復元
            $table->uuid('ingredient_uuid')->nullable();
            $table->integer('quantity')->nullable();

            // 外部キー制約を復元
            $table->foreign('ingredient_uuid')->references('uuid')->on('ingredients')->onDelete('cascade');
        });
    }
};

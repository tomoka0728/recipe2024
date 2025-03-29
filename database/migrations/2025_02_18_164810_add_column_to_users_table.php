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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'points')) {
                $table->integer('points')->default(0)->after('birth');
            }
        });

        Schema::table('ingredients', function (Blueprint $table) {
            $table->decimal('price', 8, 2)->nullable()->after('seasonality'); // 材料の価格（小数点以下2桁まで）
            $table->integer('total_purchased')->default(0)->after('price'); // 購入された累計数
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('points');
        });

        Schema::table('ingredients', function (Blueprint $table) {
            $table->dropColumn(['price', 'total_purchased']);
        });
    }
};

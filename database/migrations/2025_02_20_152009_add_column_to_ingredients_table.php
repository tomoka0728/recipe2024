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
        Schema::table('ingredients', function (Blueprint $table) {
            $table->string('unit', 10)->after('price');
            $table->string('image_path')->nullable()->after('unit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
{
    Schema::table('ingredients', function (Blueprint $table) {
        if (Schema::hasColumn('ingredients', 'unit')) {
            $table->dropColumn('unit');
        }
    });
    Schema::table('ingredients', function (Blueprint $table) {
        if (Schema::hasColumn('ingredients', 'image_path')) {
            $table->dropColumn('image_path');
        }
    });
}
};

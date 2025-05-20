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
            $table->renameColumn('ingredients_uuid', 'ingredient_uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingredients_categories', function (Blueprint $table) {
            $table->renameColumn('ingredient_uuid', 'ingredients_uuid');
        });
    }
};

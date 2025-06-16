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
        Schema::create('sales', function (Blueprint $table) {
            $table->string('uuid', '36')->primary();
            $table->uuid('ingredient_uuid');
            $table->unsignedTinyInteger('discount_percent');
            $table->timestamp('start_at');
            $table->timestamp('end_at');
            $table->timestamps();

            $table->foreign('ingredient_uuid')->references('uuid')->on('ingredients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};

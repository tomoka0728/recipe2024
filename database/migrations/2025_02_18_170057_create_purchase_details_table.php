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
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->string('uuid', 36)->primary();
            $table->string('purchase_uuid', 36);
            $table->string('ingredient_uuid', 36);
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->timestamps();

            $table->foreign('purchase_uuid')->references('uuid')->on('purchase_history')->onDelete('cascade');
            $table->foreign('ingredient_uuid')->references('uuid')->on('ingredients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_details');
    }
};

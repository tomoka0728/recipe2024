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
        Schema::create('cart_items', function (Blueprint $table) {
            $table->string('uuid', '36')->primary();
            $table->uuid('user_uuid');
            $table->uuid('ingredient_uuid');
            $table->integer('quantity');
            $table->decimal('price', 8, 2);
            $table->string('type')->default('cart'); // 初期値は 'cart'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_items');
    }
};

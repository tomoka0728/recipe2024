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
        Schema::create('point_histories', function (Blueprint $table) {
            $table->string('uuid', '36')->primary();
            $table->uuid('user_uuid');
            $table->enum('type', ['earned', 'used']); // 獲得 or 使用
            $table->integer('points'); // 増減ポイント数（マイナス値はなし）
            $table->string('description')->nullable(); // 説明
            $table->timestamps();

            $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('point_histories');
    }
};

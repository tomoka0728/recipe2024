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
        Schema::create('addresses', function (Blueprint $table) {
            $table->string('uuid', '36')->primary();;
            $table->uuid('user_uuid'); // ユーザーID（外部キー）
            $table->integer('zipcode');
            $table->string('prefectures');
            $table->string('city');
            $table->string('address');
            $table->string('room')->nullable();
            $table->integer('phone');
            $table->timestamps();

            // ユーザーIDに外部キー制約を設定
            $table->foreign('user_uuid')->references('uuid')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};

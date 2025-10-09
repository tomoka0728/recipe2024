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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->uuid('user_uuid')->nullable();
            $table->string('name');
            $table->string('email');
            $table->enum('type', ['general', 'product', 'recipe', 'account', 'payment', 'technical', 'other'])->default('general');
            $table->string('subject');
            $table->text('message');
            $table->enum('status', ['pending', 'replied', 'closed'])->default('pending');
            $table->text('admin_reply')->nullable();
            $table->timestamp('admin_replied_at')->nullable();
            $table->uuid('admin_replied_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // インデックス
            $table->index('user_uuid');
            $table->index('status');
            $table->index('type');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};

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
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->string('uuid', '36')->primary();
            $table->uuid('admin_uuid');
            $table->string('action'); // create/edit/delete
            $table->string('target_type'); // recipe or ingredient
            $table->uuid('target_uuid');
            $table->string('detail'); // レシピ登録 など
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_logs');
    }
};

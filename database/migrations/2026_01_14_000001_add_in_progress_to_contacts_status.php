<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // enumカラムを変更するため、一時的にstringに変更してから再度enumに戻す
        DB::statement("ALTER TABLE contacts MODIFY COLUMN status ENUM('pending', 'in_progress', 'replied', 'closed') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 元に戻す
        DB::statement("ALTER TABLE contacts MODIFY COLUMN status ENUM('pending', 'replied', 'closed') DEFAULT 'pending'");
    }
};

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 管理者UUIDを取得（AdminSeederで作成されたadmin）
        $adminUuid = DB::table('admin')->where('admin_id', 'admin01')->value('uuid');

        DB::table('recipes')->insert([
            'uuid' => (string) Str::uuid(),
            'user_uuid' => null,
            'admin_uuid' => $adminUuid,
            'title' => '黄金比で簡単肉じゃが',
            'description' => "おふくろの味の定番！\n黄金比で覚えやすく簡単、ホクホク、味しみしみです。\n\n牛肉で作ると味わい深くコクのある仕上がり、豚肉では牛肉よりあっさり仕上がります。お好みでお試し下さい。\n新じゃがは柔らかく煮崩れしやすいので、男爵やメークインなどがおすすめです。",
            'image_path' => 'recipe/nkjg4.jpg',
            'servings' => 4,
            'cooking_time' => 60,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecipeCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // カテゴリIDから動的にUUIDを取得
        $wasyoku = DB::table('r_categories')->where('category_id', 1)->value('uuid');
        $niku = DB::table('r_categories')->where('category_id', 4)->value('uuid');
        $buta = DB::table('r_categories')->where('category_id', 13)->value('uuid');
        $recipeUuid = DB::table('recipes')->first()->uuid ?? 'b6cb7cdb-0052-4443-ab0a-00f9a2aa8607';

        DB::table('recipe_categories')->insert([
            [
                'uuid' => (string) Str::uuid(),
                'recipe_uuid' => $recipeUuid,
                'r_category_uuid' => $wasyoku, // 和食
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'recipe_uuid' => $recipeUuid,
                'r_category_uuid' => $niku, // 肉料理
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'recipe_uuid' => $recipeUuid,
                'r_category_uuid' => $buta, // 豚肉料理
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

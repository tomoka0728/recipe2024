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
        DB::table('recipe_categories')->insert([
            [
                'uuid' => (string) Str::uuid(),
                'recipe_uuid' => 'b6cb7cdb-0052-4443-ab0a-00f9a2aa8607', // 黄金比で簡単肉じゃがのレシピUUID
                'r_category_uuid' => 'f03ec40a-e44b-4abd-b0d4-6e4d5039d5a3', // 和食
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'recipe_uuid' => 'b6cb7cdb-0052-4443-ab0a-00f9a2aa8607', // 黄金比で簡単肉じゃがのレシピUUID
                'r_category_uuid' => 'db50c5cd-9d41-468e-b3ad-4509e0afc2f1', // 肉
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'recipe_uuid' => 'b6cb7cdb-0052-4443-ab0a-00f9a2aa8607', // 黄金比で簡単肉じゃがのレシピUUID
                'r_category_uuid' => 'f7802285-143a-4611-b663-3f27dacc47fa', // 豚
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'recipe_uuid' => 'b6cb7cdb-0052-4443-ab0a-00f9a2aa8607', // 黄金比で簡単肉じゃがのレシピUUID
                'r_category_uuid' => 'eb235cf2-7d64-41ea-b5eb-22c3f357f715', // ジャガイモ
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'recipe_uuid' => 'b6cb7cdb-0052-4443-ab0a-00f9a2aa8607', // 黄金比で簡単肉じゃがのレシピUUID
                'r_category_uuid' => 'ce5a6540-19b8-4fa9-8861-502beae0718e', // にんじん
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

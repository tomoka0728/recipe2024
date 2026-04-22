<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('r_categories')->insert([
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 1,
                'name' => '和食料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 2,
                'name' => '洋食料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 3,
                'name' => '中華料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 4,
                'name' => '肉料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 5,
                'name' => '魚介料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 6,
                'name' => '野菜料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 7,
                'name' => 'ご飯もの',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 8,
                'name' => '麺類',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 9,
                'name' => 'サラダ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 10,
                'name' => 'スープ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 11,
                'name' => '副菜',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 12,
                'name' => 'パーティー料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 13,
                'name' => '豚肉料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 14,
                'name' => '鶏肉料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 15,
                'name' => '牛肉料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 16,
                'name' => '鴨肉料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 17,
                'name' => '加工肉料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 18,
                'name' => '鮭料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 19,
                'name' => '鯖料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 20,
                'name' => 'ぶり料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 21,
                'name' => '鯛料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 22,
                'name' => 'はんぺん料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 23,
                'name' => 'あさり料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 24,
                'name' => '丼もの',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 25,
                'name' => '炊き込み',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 26,
                'name' => '炒めもの',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 27,
                'name' => '雑炊',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 28,
                'name' => 'パスタ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 29,
                'name' => 'うどん',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 30,
                'name' => 'やきそば',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 31,
                'name' => 'ラーメン',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 32,
                'name' => 'フォー',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id' => 33,
                'name' => 'ビーフン',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id'=> 34,
                'name' => '温かいサラダ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id'=> 35,
                'name' => '冷たいサラダ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id'=> 36,
                'name' => '味噌汁',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id'=> 37,
                'name' => '中華スープ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id'=> 38,
                'name' => 'コンソメスープ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id'=> 39,
                'name' => 'トマトスープ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id'=> 40,
                'name' => 'ポタージュ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id'=> 41,
                'name' => 'ほうれん草',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id'=> 42,
                'name' => 'じゃがいも',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id'=> 43,
                'name' => 'きのこ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id'=> 44,
                'name' => 'にんじん',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id'=> 45,
                'name' => '小松菜',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id'=> 46,
                'name' => '豆腐',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id'=> 47,
                'name' => 'お祝い',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id'=> 48,
                'name' => '前菜',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id'=> 49,
                'name' => '大皿料理',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id'=> 50,
                'name' => 'おつまみ',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'category_id'=> 51,
                'name' => 'お弁当',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // foreach ループを追加
        $categories = DB::table('r_categories')->get();
        foreach ($categories as $category) {
            DB::table('r_categories')->updateOrInsert(
                ['category_id' => $category->category_id],
                [
                    'uuid' => (string) Str::uuid(),
                    'category_id' => $category->category_id,
                    'name' => $category->name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}

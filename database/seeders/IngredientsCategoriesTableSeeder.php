<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IngredientsCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ingredients_categories')->insert([
            ['uuid' => (string) Str::uuid(),
             'ingredients_uuid' => '1b61b51d-e80d-4984-9d4e-fe6b77da58d7',//玉ねぎ
             'i_category_uuid' => 'f94d8330-5e98-433e-bcb1-8d653a337ded',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredients_uuid' => '26624281-db75-4e46-8922-1a03587efe48', // しょうゆ
             'i_category_uuid' => '874906ba-69ce-4561-9bb7-c7bca360f7c0', // 調味料
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredients_uuid' => '3b0b0c8a-8f2f-4c51-a60f-d3a5a6b9ae55', // 水
             'i_category_uuid' => '10cd8a45-37ff-4d5c-95b6-a3d6af4ed33d', // その他
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredients_uuid' => '58306aef-91c6-4d1c-a7ef-5de1b849ae5b', // ほんだし
             'i_category_uuid' => '874906ba-69ce-4561-9bb7-c7bca360f7c0', // 調味料
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredients_uuid' => '591af533-d3a8-4ebf-9c37-c35575b9a047', // 豚肉こま切れ
             'i_category_uuid' => '0861b284-3332-4ae0-b068-4264667725c8', // 肉
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredients_uuid' => '6700ddec-48c7-4856-9590-8d2625de7ada', // みりん
             'i_category_uuid' => '874906ba-69ce-4561-9bb7-c7bca360f7c0', // 調味料
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredients_uuid' => '866ab940-2829-4091-8b54-b8ac4d5a53bc', // 砂糖
             'i_category_uuid' => '874906ba-69ce-4561-9bb7-c7bca360f7c0', // 調味料
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredients_uuid' => 'a824b379-73c6-4f16-91eb-60621df868d3', // 料理酒
             'i_category_uuid' => '874906ba-69ce-4561-9bb7-c7bca360f7c0', // 調味料
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredients_uuid' => 'c9040958-3e2a-4b25-ba1c-820ac4dda7b6', // にんじん
             'i_category_uuid' => 'f94d8330-5e98-433e-bcb1-8d653a337ded', // 野菜
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredients_uuid' => 'cdc9a092-fdd2-43f5-a197-877f2b4e598a', // じゃがいも(メークイン)
             'i_category_uuid' => 'f94d8330-5e98-433e-bcb1-8d653a337ded', // 野菜
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredients_uuid' => 'd8d01b38-d5b4-4926-b440-3f2d847e5240', // しらたき
             'i_category_uuid' => '10cd8a45-37ff-4d5c-95b6-a3d6af4ed33d', // その他
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredients_uuid' => 'ea3c9d15-befd-4cd6-86c3-9694c1cd08b7', // 塩
             'i_category_uuid' => '874906ba-69ce-4561-9bb7-c7bca360f7c0', // 調味料
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredients_uuid' => 'ffd6919b-aa1f-4736-a813-1b0ae575848d', // インゲン
             'i_category_uuid' => 'f94d8330-5e98-433e-bcb1-8d653a337ded', // 野菜
             'created_at' => now(),
             'updated_at' => now(),
            ]
        ]);
    }
}

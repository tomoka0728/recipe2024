<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;

class RecipeStepsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // レシピUUIDを取得
        $recipeUuid = DB::table('recipes')->where('title', '黄金比で簡単肉じゃが')->value('uuid');

        DB::table('recipe_steps')->insert([
            ['uuid' => (string) Str::uuid(),
             'recipe_uuid' => $recipeUuid,
             'step_number' => 1,
             'description' => '材料の下準備をします。\n・豚小間は食べやすいサイズに、じゃが芋とにんじんは乱切りに、玉ねぎはくし形切りにします。\n・しらたきはさっと茹でてアク抜きをしておきましょう。\n・インゲンも塩少々を加えた熱湯でさっと固めに茹でておきます。',
             'image_path' => 'recipe/nkjg1.jpg',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'recipe_uuid' => $recipeUuid,
             'step_number' => 2,
             'description' => '鍋にサラダ油を入れ中火で熱し、豚肉を炒めていきます。\n肉の色が変わったら、じゃがいも、にんじん、玉ねぎの順に加えて炒めます。',
             'image_path' => 'recipe/nkjg2.jpg',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'recipe_uuid' => $recipeUuid,
             'step_number' => 3,
             'description' => '煮汁の材料を加え、煮立ったらアクを取り除き、しらたきを加えます。\n蓋をして、中火のまま落し蓋をし10分ほど煮詰めます。',
             'image_path' => 'recipe/nkjg3.jpg',
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'recipe_uuid' => $recipeUuid,
             'step_number' => 4,
             'description' => 'インゲンをさっと混ぜ合わせ更に10分煮詰めていきます。\n煮汁がなくなったら火を止め落し蓋をしたまま10分蒸らして完成です。',
             'image_path' => 'recipe/nkjg4.jpg',
             'created_at' => now(),
             'updated_at' => now(),
            ],
        ]);
    }
}

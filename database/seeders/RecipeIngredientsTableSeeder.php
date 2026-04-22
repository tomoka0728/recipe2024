<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RecipeIngredientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // レシピUUIDを取得
        $recipeUuid = DB::table('recipes')->where('title', '黄金比で簡単肉じゃが')->value('uuid');

        // 材料UUIDを取得
        $butakoma = DB::table('ingredients')->where('name', '豚肉こま切れ')->value('uuid');
        $jagaimo = DB::table('ingredients')->where('name', 'じゃがいも(メークイン)')->value('uuid');
        $ninjin = DB::table('ingredients')->where('name', 'にんじん')->value('uuid');
        $tamanegi = DB::table('ingredients')->where('name', '玉ねぎ')->value('uuid');
        $sirataki = DB::table('ingredients')->where('name', 'しらたき')->value('uuid');
        $ingen = DB::table('ingredients')->where('name', 'インゲン')->value('uuid');
        $mizu = DB::table('ingredients')->where('name', '水')->value('uuid');
        $sake = DB::table('ingredients')->where('name', '料理酒')->value('uuid');
        $sato = DB::table('ingredients')->where('name', '砂糖')->value('uuid');
        $mirin = DB::table('ingredients')->where('name', 'みりん')->value('uuid');
        $syouyu = DB::table('ingredients')->where('name', 'しょうゆ')->value('uuid');
        $hondashi = DB::table('ingredients')->where('name', 'ほんだし')->value('uuid');

        DB::table('recipe_ingredients')->insert([
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => $recipeUuid,
            'ingredient_uuid' => $butakoma,
            'quantity' => 400,
            'unit' => 'g',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => $recipeUuid,
            'ingredient_uuid' => $jagaimo,
            'quantity' => 6,
            'unit' => '個',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => $recipeUuid,
            'ingredient_uuid' => $ninjin,
            'quantity' => 1,
            'unit' => '本',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => $recipeUuid,
            'ingredient_uuid' => $tamanegi,
            'quantity' => 1,
            'unit' => '個',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => $recipeUuid,
            'ingredient_uuid' => $sirataki,
            'quantity' => 1,
            'unit' => '袋',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => $recipeUuid,
            'ingredient_uuid' => $ingen,
            'quantity' => 6,
            'unit' => '本',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => $recipeUuid,
            'ingredient_uuid' => $mizu,
            'quantity' => 400,
            'unit' => 'cc',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => $recipeUuid,
            'ingredient_uuid' => $sake,
            'quantity' => '大4',
            'unit' => '杯',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => $recipeUuid,
            'ingredient_uuid' => $syouyu,
            'quantity' => '大4',
            'unit' => '杯',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => $recipeUuid,
            'ingredient_uuid' => $mirin,
            'quantity' => '大4',
            'unit' => '杯',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => $recipeUuid,
            'ingredient_uuid' => $sato,
            'quantity' => '大4',
            'unit' => '杯',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => $recipeUuid,
            'ingredient_uuid' => $hondashi,
            'quantity' => '大1',
            'unit' => '杯',
            'created_at' => now(),
            'updated_at' => now(),
            ]
        ]);
    }
}

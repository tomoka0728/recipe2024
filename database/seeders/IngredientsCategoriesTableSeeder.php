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
        // 材料名からUUIDを取得
        $tamanegi = DB::table('ingredients')->where('name', '玉ねぎ')->value('uuid');
        $syouyu = DB::table('ingredients')->where('name', 'しょうゆ')->value('uuid');
        $mizu = DB::table('ingredients')->where('name', '水')->value('uuid');
        $hondashi = DB::table('ingredients')->where('name', 'ほんだし')->value('uuid');
        $butakoma = DB::table('ingredients')->where('name', '豚肉こま切れ')->value('uuid');
        $mirin = DB::table('ingredients')->where('name', 'みりん')->value('uuid');
        $sato = DB::table('ingredients')->where('name', '砂糖')->value('uuid');
        $ryorisyu = DB::table('ingredients')->where('name', '料理酒')->value('uuid');
        $ninjin = DB::table('ingredients')->where('name', 'にんじん')->value('uuid');
        $jagaimo = DB::table('ingredients')->where('name', 'じゃがいも(メークイン)')->value('uuid');
        $sirataki = DB::table('ingredients')->where('name', 'しらたき')->value('uuid');

        // カテゴリIDからUUIDを取得
        $yasai = DB::table('i_categories')->where('category_id', 4)->value('uuid'); // 野菜
        $tyomiryou = DB::table('i_categories')->where('category_id', 9)->value('uuid'); // 調味料
        $sonota = DB::table('i_categories')->where('category_id', 11)->value('uuid'); // その他
        $niku = DB::table('i_categories')->where('category_id', 1)->value('uuid'); // 肉

        DB::table('ingredients_categories')->insert([
            ['uuid' => (string) Str::uuid(),
             'ingredient_uuid' => $tamanegi,
             'i_category_uuid' => $yasai,
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredient_uuid' => $syouyu,
             'i_category_uuid' => $tyomiryou,
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredient_uuid' => $mizu,
             'i_category_uuid' => $sonota,
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredient_uuid' => $hondashi,
             'i_category_uuid' => $tyomiryou,
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredient_uuid' => $butakoma,
             'i_category_uuid' => $niku,
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredient_uuid' => $mirin,
             'i_category_uuid' => $tyomiryou,
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredient_uuid' => $sato,
             'i_category_uuid' => $tyomiryou,
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredient_uuid' => $ryorisyu,
             'i_category_uuid' => $tyomiryou,
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredient_uuid' => $ninjin,
             'i_category_uuid' => $yasai,
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredient_uuid' => $jagaimo,
             'i_category_uuid' => $yasai,
             'created_at' => now(),
             'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
             'ingredient_uuid' => $sirataki,
             'i_category_uuid' => $sonota,
             'created_at' => now(),
             'updated_at' => now(),
            ],
        ]);
    }
}

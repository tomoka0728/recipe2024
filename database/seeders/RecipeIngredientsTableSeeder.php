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
        DB::table('recipe_ingredients')->insert([
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => 'b6cb7cdb-0052-4443-ab0a-00f9a2aa8607',
            'ingredient_uuid' => '591af533-d3a8-4ebf-9c37-c35575b9a047',//豚こま
            'quantity' => 400,
            'unit' => 'g',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => 'b6cb7cdb-0052-4443-ab0a-00f9a2aa8607',
            'ingredient_uuid' => 'cdc9a092-fdd2-43f5-a197-877f2b4e598a',//じゃがいも(メークイン)
            'quantity' => 6,
            'unit' => '個',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => 'b6cb7cdb-0052-4443-ab0a-00f9a2aa8607',
            'ingredient_uuid' => 'c9040958-3e2a-4b25-ba1c-820ac4dda7b6',//にんじん
            'quantity' => 1,
            'unit' => '本',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => 'b6cb7cdb-0052-4443-ab0a-00f9a2aa8607',
            'ingredient_uuid' => '1b61b51d-e80d-4984-9d4e-fe6b77da58d7',//玉ねぎ
            'quantity' => 1,
            'unit' => '個',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => 'b6cb7cdb-0052-4443-ab0a-00f9a2aa8607',
            'ingredient_uuid' => 'd8d01b38-d5b4-4926-b440-3f2d847e5240',//しらたき
            'quantity' => 1,
            'unit' => '袋',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => 'b6cb7cdb-0052-4443-ab0a-00f9a2aa8607',
            'ingredient_uuid' => 'ffd6919b-aa1f-4736-a813-1b0ae575848d',//インゲン
            'quantity' => 6,
            'unit' => '本',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => 'b6cb7cdb-0052-4443-ab0a-00f9a2aa8607',
            'ingredient_uuid' => '3b0b0c8a-8f2f-4c51-a60f-d3a5a6b9ae55',//水
            'quantity' => 400,
            'unit' => 'cc',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => 'b6cb7cdb-0052-4443-ab0a-00f9a2aa8607',
            'ingredient_uuid' => 'a824b379-73c6-4f16-91eb-60621df868d3',//酒
            'quantity' => '大4',
            'unit' => '杯',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => 'b6cb7cdb-0052-4443-ab0a-00f9a2aa8607',
            'ingredient_uuid' => '26624281-db75-4e46-8922-1a03587efe48',//しょうゆ
            'quantity' => '大4',
            'unit' => '杯',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => 'b6cb7cdb-0052-4443-ab0a-00f9a2aa8607',
            'ingredient_uuid' => '6700ddec-48c7-4856-9590-8d2625de7ada',//みりん
            'quantity' => '大4',
            'unit' => '杯',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => 'b6cb7cdb-0052-4443-ab0a-00f9a2aa8607',
            'ingredient_uuid' => '866ab940-2829-4091-8b54-b8ac4d5a53bc',//砂糖
            'quantity' => '大4',
            'unit' => '杯',
            'created_at' => now(),
            'updated_at' => now(),
            ],
            ['uuid' => (string) Str::uuid(),
            'recipe_uuid' => 'b6cb7cdb-0052-4443-ab0a-00f9a2aa8607',
            'ingredient_uuid' => '58306aef-91c6-4d1c-a7ef-5de1b849ae5b',//だし
            'quantity' => '大1',
            'unit' => '杯',
            'created_at' => now(),
            'updated_at' => now(),
            ]
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // シーダーを実行順に呼び出し
        $this->call([
            CategoryGroupSeeder::class,
            ICategoriesTableSeeder::class,
            RCategoriesTableSeeder::class,
            IngredientsTableSeeder::class,
            IngredientsCategoriesTableSeeder::class,
            RecipesTableSeeder::class,
            RecipeIngredientsTableSeeder::class,
            RecipeCategoriesTableSeeder::class,
            RecipeStepsTableSeeder::class,
            AdminSeeder::class,
        ]);
    }
}

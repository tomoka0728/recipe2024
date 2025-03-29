<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use App\Models\Ingredient;

class RecipeController extends Controller
{
    public function show($uuid)
    {
        // uuidでレシピを取得し、関連する材料と手順も取得
        $recipe = Recipe::with(['recipeIngredients.ingredient', 'steps'])
                ->where('uuid', $uuid)
                ->firstOrFail();

        $recipe->steps = $recipe->steps->sortBy('step_number');

        foreach ($recipe->recipeIngredients as $recipeIngredient) {
            if ($recipeIngredient->ingredient) {
                // ingredient_id が DB に存在するかチェック
                $recipeIngredient->ingredient->exists_in_db = Ingredient::where('uuid', $recipeIngredient->ingredient->id)->exists();
            }
        }

        return view('recipes.show', compact('recipe'));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RecipeIngredient;

class Recipe extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    // RecipeIngredientとのリレーション
    public function recipeIngredients()
    {
        return $this->hasMany(RecipeIngredient::class, 'recipe_uuid', 'uuid');
    }

    // Ingredientとのリレーション
    public function ingredients()
    {
        return $this->hasManyThrough(
            Ingredient::class,
            RecipeIngredient::class,
            'recipe_uuid',     // RecipeIngredientテーブルでの外部キー
            'uuid',             // Ingredientテーブルでの主キー
            'uuid',             // Recipeテーブルでの主キー
            'ingredient_uuid'   // RecipeIngredientテーブルでの外部キー
        );
    }

    // RecipeStepとのリレーション
    public function steps()
    {
        return $this->hasMany(RecipeStep::class, 'recipe_uuid', 'uuid');
    }
}

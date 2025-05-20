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
        return $this->belongsToMany(
            Ingredient::class,
            'recipe_ingredients',      // 中間テーブル名
            'recipe_uuid',             // 中間テーブルでのレシピ側外部キー
            'ingredient_uuid',         // 中間テーブルでの材料側外部キー
            'uuid',                    // Recipeモデルの主キー
            'uuid'                     // Ingredientモデルの主キー
        )->withPivot('uuid', 'quantity', 'unit')->withTimestamps();
    }

    // RecipeStepとのリレーション
    public function steps()
    {
        return $this->hasMany(RecipeStep::class, 'recipe_uuid', 'uuid')->orderBy('step_number');
    }

    // RecipeCategoryとのリレーション
    public function categories()
    {
        return $this->belongsToMany(RCategory::class, 'recipe_categories', 'recipe_uuid', 'r_category_uuid');
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

}

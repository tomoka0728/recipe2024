<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeIngredient extends Model
{
    use HasFactory;

    // recipe_ingredients テーブルに対応
    protected $table = 'recipe_ingredients'; // テーブル名が異なる場合は変更

    // recipe_uuid, ingredient_uuid など、必要なカラムをfillableに追加
    protected $fillable = [
        'recipe_uuid', 'ingredient_uuid', 'quantity', // 適切なカラム名を記入
    ];

    // Recipeとのリレーション
    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_uuid', 'uuid');
    }

    // Ingredientとのリレーション
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_uuid', 'uuid');
    }
}


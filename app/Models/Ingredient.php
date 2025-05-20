<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'name',
        'seasonality',
        'price',
        'unit',
        'image_path',
        'total_purchased',
    ];
    // キャスト設定
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function recipeIngredients()
    {
        return $this->hasMany(RecipeIngredient::class, 'ingredient_uuid', 'uuid');
    }

    public function recipes()
    {
        return $this->hasManyThrough(Recipe::class, RecipeIngredient::class, 'ingredient_uuid', 'uuid', 'uuid', 'recipe_uuid');
    }

    public function ingredientCategories()
    {
        return $this->hasMany(IngredientCategory::class, 'ingredient_uuid', 'uuid');
    }


    public function getExistsInDbAttribute()
    {
        return !is_null($this->uuid);
    }

    public function categories()
    {
        return $this->belongsToMany(
            ICategory::class, // `i_categories` モデル
            'ingredients_categories', // 中間テーブル
            'ingredient_uuid', // 中間テーブルの ingredients の外部キー
            'i_category_uuid' // 中間テーブルの categories の外部キー
        );
    }
}

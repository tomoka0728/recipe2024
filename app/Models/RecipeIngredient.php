<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RecipeIngredient extends Model
{
    use HasFactory;

    // recipe_ingredients テーブルに対応
    protected $table = 'recipe_ingredients';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid','recipe_uuid', 'ingredient_uuid', 'quantity', 'unit',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = Str::uuid(); // uuid を自動生成
            }
        });
    }

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


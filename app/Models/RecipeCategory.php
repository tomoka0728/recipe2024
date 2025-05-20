<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RecipeCategory extends Model
{
    use HasFactory;

    protected $table = 'recipe_categories';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'recipe_uuid',
        'r_category_uuid',
    ];

    // Recipeとのリレーション
    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_uuid', 'uuid');
    }

    // RCategoryとのリレーション
    public function rCategory()
    {
        return $this->belongsTo(RCategory::class, 'r_category_uuid', 'uuid');
    }
}

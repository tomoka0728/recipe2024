<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RCategory extends Model
{
    use HasFactory;

    protected $table = 'r_categories';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    // Recipeとの多対多リレーション
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipe_categories', 'r_category_uuid', 'recipe_uuid');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoriteRecipe extends Model
{
    use HasFactory;

    protected $table = 'favorite_recipes';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'user_uuid',
        'recipe_uuid',
    ];

    // Userとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    // Recipeとのリレーション
    public function recipe()
    {
        return $this->belongsTo(Recipe::class, 'recipe_uuid', 'uuid');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecipeStep extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';  // または適切な主キー
    public $timestamps = false;    // タイムスタンプが不要なら

    protected $fillable = [
        'recipe_uuid',
        'step_number',
        'description',
        'image_path'
    ];
}

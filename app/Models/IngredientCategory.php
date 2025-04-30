<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngredientCategory extends Model
{
    protected $table = 'ingredients_categories';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['uuid', 'ingredients_uuid', 'i_category_uuid'];
}

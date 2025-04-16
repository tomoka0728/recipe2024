<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['uuid', 'user_uuid', 'ingredient_uuid', 'quantity',];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_uuid', 'uuid');
    }
}

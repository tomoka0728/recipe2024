<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RecipeStep extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';
    public $timestamps = false;

    protected $fillable = [
        'uuid',
        'recipe_uuid',
        'step_number',
        'description',
        'image_path'
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
}

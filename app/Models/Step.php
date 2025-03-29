<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;

    // 明示的にテーブル名を指定
    protected $table = 'recipe_steps';

    // 必要に応じて他のカラムを設定
    protected $fillable = ['uuid', 'recipe_uuid', 'description'];

    public function recipe()
    {
        // レシピに対する逆リレーションを定義
        return $this->belongsTo(Recipe::class, 'recipe_uuid', 'uuid');
    }
}

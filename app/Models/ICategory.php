<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ICategory extends Model
{
    use HasFactory;

    protected $table = 'i_categories'; // テーブル名を明示的に指定
    protected $primaryKey = 'uuid'; // 主キーは `uuid`
    public $incrementing = false; // `uuid` は自動増加しない
    protected $keyType = 'string'; // 主キーの型を `string` に設定

    protected $fillable = ['uuid', 'i_category_id', 'name'];

    public function ingredients()
    {
        return $this->belongsToMany(
            Ingredient::class, // `ingredients` テーブルと紐付ける
            'ingredients_categories', // 中間テーブル
            'i_category_uuid', // 自分のキー（カテゴリーID）
            'ingredients_uuid' // 相手のキー（材料ID）
        );
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SavedItem extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['uuid', 'user_uuid', 'item_type', 'item_uuid', 'ingredient_uuid', 'quantity'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    // ポリモーフィックリレーション
    public function item()
    {
        return $this->morphTo('item', 'item_type', 'item_uuid');
    }

    // ユーザーとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    // 後方互換性のための食材リレーション
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_uuid', 'uuid');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class CartItem extends Model
{
    use HasFactory;

    protected $table = 'cart_items';
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid',
        'user_uuid',
        'ingredient_uuid',
        'quantity',
        'price',
        'type',
    ];

    protected static function booted()
    {
        static::creating(function ($cartItem) {
            if (empty($cartItem->uuid)) {
                $cartItem->uuid = (string) Str::uuid();
            }
        });
    }

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_uuid', 'uuid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid', 'ingredient_uuid', 'discount_percent', 'start_at', 'end_at'
    ];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_uuid', 'uuid');
    }
}

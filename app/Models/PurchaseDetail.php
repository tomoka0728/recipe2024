<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    use HasFactory;

    protected $table = 'purchase_details';

    protected $fillable = [
        'purchase_uuid',
        'ingredient_uuid',
        'quantity',
        'price',
        'type',
    ];

    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class, 'ingredient_uuid', 'uuid');
    }
}

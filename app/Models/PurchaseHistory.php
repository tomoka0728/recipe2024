<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseHistory extends Model
{
    protected $table = 'purchase_history';

    protected $fillable = [
        'uuid',
        'user_uuid',
        'total_price',
        'purchased_at',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    public function details()
    {
        return $this->hasMany(PurchaseDetail::class, 'purchase_uuid', 'uuid');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }
}

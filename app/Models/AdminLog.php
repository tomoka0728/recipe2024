<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class AdminLog extends Model
{
    use HasFactory;

    protected $primaryKey = 'uuid';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'uuid', 'admin_uuid', 'action', 'target_type', 'target_uuid', 'detail'
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_uuid', 'uuid');
    }
}

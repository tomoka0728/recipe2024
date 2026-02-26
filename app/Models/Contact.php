<?php

namespace App\Models;

use App\Enums\ContactStatus;
use App\Enums\ContactType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'uuid',
        'user_uuid',
        'name',
        'email',
        'type',
        'subject',
        'message',
        'status',
        'admin_reply',
        'admin_replied_at',
        'admin_replied_by',
    ];

    protected $casts = [
        'type' => ContactType::class,
        'status' => ContactStatus::class,
        'admin_replied_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
            if (empty($model->status)) {
                $model->status = ContactStatus::PENDING;
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    // ユーザーとのリレーション
    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    // 返答した管理者とのリレーション
    public function adminRepliedBy()
    {
        return $this->belongsTo(Admin::class, 'admin_replied_by', 'uuid');
    }

    // メッセージ履歴
    public function messages()
    {
        return $this->hasMany(ContactMessage::class)->orderBy('created_at', 'asc');
    }

    // ステータスの日本語表示
    public function getStatusLabelAttribute()
    {
        return $this->status->label();
    }

    // タイプの日本語表示
    public function getTypeLabelAttribute()
    {
        return $this->type->label();
    }
}

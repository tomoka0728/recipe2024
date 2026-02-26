<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'sender_type',
        'sender_id',
        'message',
    ];

    /**
     * メッセージが属するお問い合わせ
     */
    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    /**
     * 送信者（ユーザー）
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'sender_id', 'uuid');
    }

    /**
     * 送信者（管理者）
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'sender_id', 'uuid');
    }

    /**
     * 送信者名を取得
     */
    public function getSenderNameAttribute()
    {
        if ($this->sender_type === 'admin') {
            return $this->admin ? $this->admin->admin_name : '管理者';
        } else {
            return $this->user ? $this->user->name : $this->contact->name;
        }
    }
}

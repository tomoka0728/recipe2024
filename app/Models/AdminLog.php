<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Enums\AdminLogAction;
use App\Enums\AdminLogTargetType;

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

    //管理者ログを記録する共通メソッド
    public static function record(
        string $adminUuid,
        AdminLogAction $action,
        AdminLogTargetType $targetType,
        string $targetUuid,
        string $detail
    ) {
        return self::create([
            'uuid'        => (string)Str::uuid(),
            'admin_uuid'  => $adminUuid,
            'action'      => $action->value,
            'target_type' => $targetType->value,
            'target_uuid' => $targetUuid,
            'detail'      => $detail,
        ]);
    }

    public function getActionTextAttribute()
    {
        return match($this->action) {
            'create' => 'がレシピ登録',
            'edit'   => 'がレシピ編集',
            'delete' => 'がレシピ削除',
            default  => 'が操作',
        };
    }

    public function getRecipeLinkAttribute()
    {
        if ($this->target_type === 'recipe') {
            return route('admin.recipes.edit', ['uuid' => $this->target_uuid]);
        }
        if ($this->target_type === 'ingredient') {
            return route('admin.ingredients.edit', ['uuid' => $this->target_uuid]);
        }
        return null;
    }
}

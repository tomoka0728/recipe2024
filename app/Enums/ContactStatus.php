<?php

namespace App\Enums;

enum ContactStatus: string
{
    case PENDING = 'pending';
    case REPLIED = 'replied';
    case CLOSED = 'closed';

    public function label(): string
    {
        return match($this) {
            self::PENDING => '未対応',
            self::REPLIED => '返答済み',
            self::CLOSED => '完了',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }
}

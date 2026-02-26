<?php

namespace App\Enums;

enum ContactStatus: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case REPLIED = 'replied';
    case CLOSED = 'closed';

    public function label(): string
    {
        return match($this) {
            self::PENDING => '未対応',
            self::IN_PROGRESS => '対応中',
            self::REPLIED => '対応中',  // IN_PROGRESSと同じ扱い
            self::CLOSED => '対応済み',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }
}

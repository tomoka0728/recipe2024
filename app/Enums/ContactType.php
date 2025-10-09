<?php

namespace App\Enums;

enum ContactType: string
{
    case GENERAL = 'general';
    case PRODUCT = 'product';
    case RECIPE = 'recipe';
    case ACCOUNT = 'account';
    case PAYMENT = 'payment';
    case TECHNICAL = 'technical';
    case OTHER = 'other';

    public function label(): string
    {
        return match($this) {
            self::GENERAL => '一般的なお問い合わせ',
            self::PRODUCT => '商品について',
            self::RECIPE => 'レシピについて',
            self::ACCOUNT => 'アカウント・会員について',
            self::PAYMENT => '決済・料金について',
            self::TECHNICAL => '技術的な問題',
            self::OTHER => 'その他',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())->mapWithKeys(fn($case) => [
            $case->value => $case->label()
        ])->toArray();
    }
}

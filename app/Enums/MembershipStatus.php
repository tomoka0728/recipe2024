<?php

namespace App\Enums;

enum MembershipStatus: int
{
    case General = 1;
    case Silver = 2;
    case Gold = 3;

    public function isPremium(): bool
    {
        return in_array($this, [self::Silver, self::Gold]);
    }
}

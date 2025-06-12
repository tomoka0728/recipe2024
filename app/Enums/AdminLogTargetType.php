<?php

namespace App\Enums;

enum AdminLogTargetType: string
{
    case RECIPE = 'recipe';
    case INGREDIENT = 'ingredient';
}

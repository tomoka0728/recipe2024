<?php

namespace App\Enums;

enum CategoryGroup: string
{
    case MEAT = 'meat';
    case SEAFOOD = 'seafood';
    case RICE = 'rice';
    case NOODLE = 'noodle';
    case SALAD = 'salad';
    case SOUP = 'soup';
    case SIDE = 'side';
    case PARTY = 'party';
}

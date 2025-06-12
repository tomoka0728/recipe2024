<?php

namespace App\Enums;

enum AdminLogAction: string
{
    case CREATE = 'create';
    case EDIT = 'edit';
    case DELETE = 'delete';
}

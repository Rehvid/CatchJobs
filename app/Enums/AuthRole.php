<?php

declare(strict_types=1);

namespace App\Enums;

enum AuthRole: String
{
    case ADMIN = 'admin';
    case EMPLOYER = 'employer';

    case USER = 'user';
}

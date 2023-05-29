<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: String
{
    case ADMIN = 'admin';
    case EMPLOYER = 'employer';

    case USER = 'user';
}

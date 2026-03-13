<?php

namespace App\Enums;

enum RoleType: string
{
    case Admin = 'admin';
    case User = 'user';

    public function description(): string
    {
        return match ($this) {
            self::Admin => 'Administrator',
            self::User => 'User',
        };
    }
}


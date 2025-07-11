<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;
use Illuminate\Contracts\Support\Htmlable;

enum UserRole: string implements HasLabel
{
    case Admin = 'admin';
    case Teacher = 'teacher';
    case Staff = 'staff';

    public function getLabel(): string | Htmlable | null
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Teacher => 'Teacher',
            self::Staff => 'Staff',
        };
    }
}

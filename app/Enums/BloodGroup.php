<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum BloodGroup: string implements HasLabel
{
    case APositive = 'a+';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::APositive => 'A+ (A positive)'
        };
    }
}

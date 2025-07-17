<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum AttendanceStatus: string implements HasColor, HasLabel
{
    case Present = 'present';
    case Absent = 'absent';
    case Leave = 'leave';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Present => 'Present',
            self::Absent => 'Absent',
            self::Leave => 'Leave',
            default => '-',
        };
    }

    public function getShortLabel(): ?string
    {
        return match ($this) {
            self::Present => 'P',
            self::Absent => 'A',
            self::Leave => 'L',
            default => '-',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Present => 'success',
            self::Absent => 'danger',
            self::Leave => 'warning',
            default => 'gray',
        };
    }
}

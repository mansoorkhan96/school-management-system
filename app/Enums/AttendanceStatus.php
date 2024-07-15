<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AttendanceStatus: string implements HasLabel
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
        };
    }
}

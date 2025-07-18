<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum ExaminationReportType: string implements HasLabel
{
    case Mid = 'mid';
    case Annual = 'annual';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Mid => 'Mid-Term Examination',
            self::Annual => 'Annual/Final Examination',
        };
    }
}

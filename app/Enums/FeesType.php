<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum FeesType: string implements HasLabel
{
    case Examination = 'examination';
    case Admission = 'admission';
    case Other = 'other';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Examination => 'Examination Fees',
            self::Admission => 'Admission Fees',
            self::Other => 'Other Fees',
        };
    }
}

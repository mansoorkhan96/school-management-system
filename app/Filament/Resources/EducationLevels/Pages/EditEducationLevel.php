<?php

namespace App\Filament\Resources\EducationLevels\Pages;

use Filament\Support\Enums\Width;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\EducationLevels\EducationLevelResource;
use Filament\Resources\Pages\EditRecord;

class EditEducationLevel extends EditRecord
{
    protected static string $resource = EducationLevelResource::class;

    protected Width|string|null $maxContentWidth = 'full';

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
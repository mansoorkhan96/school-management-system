<?php

namespace App\Filament\Resources\EducationLevelResource\Pages;

use Filament\Support\Enums\Width;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\EducationLevelResource;
use Filament\Actions;
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

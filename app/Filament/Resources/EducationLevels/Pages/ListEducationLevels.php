<?php

namespace App\Filament\Resources\EducationLevels\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\EducationLevels\EducationLevelResource;
use Filament\Resources\Pages\ListRecords;

class ListEducationLevels extends ListRecords
{
    protected static string $resource = EducationLevelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
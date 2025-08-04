<?php

namespace App\Filament\Resources\Fees\Pages;

use App\Filament\Resources\Fees\FeesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFees extends EditRecord
{
    protected static string $resource = FeesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
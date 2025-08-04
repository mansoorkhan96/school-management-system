<?php

namespace App\Filament\Resources\Fees\Pages;

use App\Filament\Resources\Fees\FeesResource;
use Filament\Resources\Pages\CreateRecord;

class CreateFees extends CreateRecord
{
    protected static string $resource = FeesResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
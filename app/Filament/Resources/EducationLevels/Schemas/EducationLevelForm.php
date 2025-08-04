<?php

namespace App\Filament\Resources\EducationLevels\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EducationLevelForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Class Teacher')
                    ->relationship('user', 'name'),
                TextInput::make('name')
                    ->required(),
            ]);
    }
}
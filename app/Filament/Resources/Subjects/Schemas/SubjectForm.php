<?php

namespace App\Filament\Resources\Subjects\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SubjectForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Teacher')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('education_level_id')
                    ->relationship('educationLevel', 'name')
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('max_marks')
                    ->required()
                    ->numeric(),
                TextInput::make('min_passing_marks')
                    ->required()
                    ->numeric(),
            ]);
    }
}
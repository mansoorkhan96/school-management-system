<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\UserRole;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ToggleButtons::make('role')
                    ->options(UserRole::class)
                    ->inline()
                    ->required(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->email()
                    ->unique()
                    ->required(),
                // TODO:
                TextInput::make('password')
                    ->dehydrated(fn ($state) => filled($state))
                    ->password(),
            ]);
    }
}

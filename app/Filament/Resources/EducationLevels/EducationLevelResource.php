<?php

namespace App\Filament\Resources\EducationLevels;

use App\Filament\Resources\EducationLevels\Pages\CreateEducationLevel;
use App\Filament\Resources\EducationLevels\Pages\EditEducationLevel;
use App\Filament\Resources\EducationLevels\Pages\ListEducationLevels;
use App\Filament\Resources\EducationLevels\Pages\TakeAttendance;
use App\Filament\Resources\EducationLevels\RelationManagers\AttendancesRelationManager;
use App\Filament\Resources\EducationLevels\Schemas\EducationLevelForm;
use App\Filament\Resources\EducationLevels\Tables\EducationLevelTable;
use App\Models\EducationLevel;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class EducationLevelResource extends Resource
{
    protected static ?string $model = EducationLevel::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Schema $schema): Schema
    {
        return EducationLevelForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EducationLevelTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            AttendancesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEducationLevels::route('/'),
            'create' => CreateEducationLevel::route('/create'),
            'edit' => EditEducationLevel::route('/{record}/edit'),
            'take-attendance' => TakeAttendance::route('/{record}/take-attendance'),
        ];
    }
}
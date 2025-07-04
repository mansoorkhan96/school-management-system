<?php

namespace App\Filament\Resources;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Resources\EducationLevelResource\Pages\ListEducationLevels;
use App\Filament\Resources\EducationLevelResource\Pages\CreateEducationLevel;
use App\Filament\Resources\EducationLevelResource\Pages\EditEducationLevel;
use App\Filament\Resources\EducationLevelResource\Pages\TakeAttendance;
use App\Filament\Resources\EducationLevelResource\Pages;
use App\Filament\Resources\EducationLevelResource\RelationManagers\AttendancesRelationManager;
use App\Models\EducationLevel;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EducationLevelResource extends Resource
{
    protected static ?string $model = EducationLevel::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-academic-cap';

    public static function form(Schema $schema): Schema
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Class Teacher')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('take-attendance')
                    ->url(fn (EducationLevel $record) => self::getUrl('take-attendance', ['record' => $record])),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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

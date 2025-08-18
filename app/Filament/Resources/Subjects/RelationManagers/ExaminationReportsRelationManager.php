<?php

namespace App\Filament\Resources\Subjects\RelationManagers;

use App\Enums\ExaminationReportType;
use App\Filament\Resources\Subjects\SubjectResource;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ExaminationReportsRelationManager extends RelationManager
{
    protected static string $relationship = 'examinationReports';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('obtained_marks')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue($this->getOwnerRecord()->max_marks)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('student.name')
                    ->searchable(),
                TextColumn::make('type')
                    ->label('Type')
                    ->searchable(),
                TextColumn::make('year')
                    ->label('Year')
                    ->searchable(),
                TextColumn::make('obtained_marks')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->options(ExaminationReportType::class)
                    ->default(ExaminationReportType::Annual->value)
                    ->selectablePlaceholder(false),
                SelectFilter::make('year')
                    ->options(fn () => range(now()->year, 2010))
                    ->default(now()->year)
                    ->selectablePlaceholder(false),
            ])
            ->headerActions([
                CreateAction::make()
                    ->url(fn () => SubjectResource::getUrl('create-examination-report', ['record' => $this->getOwnerRecord()]))
                    ->openUrlInNewTab(),
            ])
            ->recordActions([
                EditAction::make(),
            ]);
    }
}

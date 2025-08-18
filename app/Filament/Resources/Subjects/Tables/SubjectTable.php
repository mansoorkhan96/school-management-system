<?php

namespace App\Filament\Resources\Subjects\Tables;

use App\Filament\Resources\Subjects\SubjectResource;
use App\Models\Subject;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SubjectTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Teacher')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('educationLevel.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('max_marks')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('min_passing_marks')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('create-examination-report')
                    ->label('Create Examination Report')
                    ->icon(Heroicon::OutlinedDocumentText)
                    ->url(fn (Subject $record) => SubjectResource::getUrl('create-examination-report', ['record' => $record])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}

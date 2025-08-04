<?php

namespace App\Filament\Resources\Fees\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class FeesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('student.registery_number')
                    ->label('Student ID')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('student.first_name')
                    ->label('Student Name')
                    ->formatStateUsing(fn ($record) => "{$record->student->first_name} {$record->student->last_name}")
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),
                TextColumn::make('educationLevel.name')
                    ->label('Class')
                    ->sortable(),
                TextColumn::make('type')
                    ->label('Fee Type')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->money('USD')
                    ->sortable(),
                IconColumn::make('is_paid')
                    ->label('Paid')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                TextColumn::make('month_name')
                    ->label('Month')
                    ->toggleable(),
                TextColumn::make('year')
                    ->label('Year')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('due_date')
                    ->label('Due Date')
                    ->date()
                    ->sortable()
                    ->color(fn ($record) => $record->is_overdue ? 'danger' : null),
                TextColumn::make('payment_date')
                    ->label('Paid Date')
                    ->date()
                    ->sortable()
                    ->placeholder('Not paid')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('education_level_id')
                    ->label('Class')
                    ->relationship('educationLevel', 'name')
                    ->multiple(),
                SelectFilter::make('fee_month')
                    ->label('Month')
                    ->options([
                        1 => 'January',
                        2 => 'February',
                        3 => 'March',
                        4 => 'April',
                        5 => 'May',
                        6 => 'June',
                        7 => 'July',
                        8 => 'August',
                        9 => 'September',
                        10 => 'October',
                        11 => 'November',
                        12 => 'December',
                    ])
                    ->multiple(),
                SelectFilter::make('year')
                    ->options([
                        2020 => '2020',
                        2021 => '2021',
                        2022 => '2022',
                        2023 => '2023',
                        2024 => '2024',
                        2025 => '2025',
                    ])
                    ->multiple(),
                Filter::make('overdue')
                    ->label('Overdue Fees')
                    ->query(fn (Builder $query) => $query->where('due_date', '<', now())->whereNull('payment_date'))
                    ->toggle(),
                Filter::make('unpaid')
                    ->label('Unpaid Fees')
                    ->query(fn (Builder $query) => $query->whereNull('payment_date'))
                    ->toggle(),
                Filter::make('paid')
                    ->label('Paid Fees')
                    ->query(fn (Builder $query) => $query->whereNotNull('payment_date'))
                    ->toggle(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}

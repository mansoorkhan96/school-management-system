<?php

namespace App\Filament\Resources\Fees\Schemas;

use App\Enums\FeesType;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FeesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Group::make([
                    Section::make('Fee Details')
                        ->columns(1)
                        ->components([
                            Select::make('student_id')
                                ->label('Student')
                                ->relationship('student', 'first_name')
                                ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->first_name} {$record->last_name} ({$record->registery_number})")
                                ->searchable(['first_name', 'last_name', 'registery_number'])
                                ->required(),
                            TextInput::make('amount')
                                ->label('Amount')
                                ->numeric()
                                ->prefix('$')
                                ->required(),
                            Select::make('type')
                                ->label('Fee Type')
                                ->options(FeesType::class)
                                ->columnSpanFull(),
                        ]),
                ])->columnSpan(1),
                Group::make([
                    Section::make('Payment Schedule')
                        ->components([
                            Select::make('fee_month')
                                ->label('Fee Month')
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
                                ->placeholder('Select month'),
                            TextInput::make('year')
                                ->label('Year')
                                ->numeric()
                                ->default(now()->year)
                                ->minValue(now()->year)
                                ->maxValue(now()->year + 1)
                                ->required(),
                            DatePicker::make('due_date')
                                ->label('Due Date')
                                ->native(false),
                            DatePicker::make('payment_date')
                                ->label('Payment Date')
                                ->native(false)
                                ->helperText('Leave empty if not paid yet'),
                            Textarea::make('description')
                                ->label('Description')
                                ->placeholder('Additional notes about this fee')
                                ->rows(3)
                                ->columnSpanFull(),
                        ]),
                ])->columnSpan(1),
            ]);
    }
}

<?php

namespace App\Filament\Resources\EducationLevelResource\RelationManagers;

use App\Enums\AttendanceStatus;
use App\Models\Student;
use Filament\Actions\Action;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class AttendancesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendances';

    public ?Carbon $month = null;

    public function table(Table $table): Table
    {
        $this->month ??= now();

        $start = $this->month->copy()->startOfMonth();
        $end = $this->month->copy()->endOfMonth();

        $dates = collect();
        while ($start->lte($end)) {
            $dates->push($start->copy());
            $start->addDay();
        }

        return $table
            ->heading("Attendance Report ({$this->month->monthName})")
            ->query(Student::query()->where('education_level_id', $this->getOwnerRecord()->getKey()))
            ->columns([
                TextColumn::make('name')
                    ->sortable(),
                TextColumn::make('surname')
                    ->sortable(['first_name']),
                ...$dates->map(fn (Carbon $date, $index) => TextColumn::make("attendance_{$index}")
                    ->label($date->day)
                    ->getStateUsing(function (Student $record) use ($date) {
                        if ($date->isSunday()) {
                            return '|';
                        }

                        $attendance = $record->attendances()->whereDate('date', $date)->first();

                        return $attendance ? $attendance->attendance_status : '-';
                    })
                    ->weight(fn () => $date->isSunday() ? FontWeight::Normal : FontWeight::Bold)
                    ->formatStateUsing(fn ($state) => $state instanceof AttendanceStatus ? $state->getShortLabel() : $state)
                )->toArray(),
            ])
            ->headerActions([
                Action::make('filter')
                    ->icon('heroicon-o-funnel')
                    ->fillForm(['month' => $this->month->month])
                    ->schema([
                        ToggleButtons::make('month')
                            ->inline()
                            ->required()
                            ->options([
                                1 => 'Jan',
                                2 => 'Feb',
                                8 => 'Aug',
                            ])
                            ->default(now()->month),
                    ])
                    ->action(function (array $data, self $livewire) {
                        $this->month = now()->month((int) $data['month']);
                    }),
            ]);
    }
}

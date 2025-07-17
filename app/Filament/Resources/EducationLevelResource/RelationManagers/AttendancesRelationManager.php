<?php

namespace App\Filament\Resources\EducationLevelResource\RelationManagers;

use App\Enums\AttendanceStatus;
use App\Models\Student;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;

class AttendancesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendances';

    public ?int $month = null;

    public function table(Table $table): Table
    {
        $this->month ??= now()->month;

        $month = Carbon::createFromDate(now()->year, $this->month, 1);

        $start = $month->copy()->startOfMonth();
        $end = $month->copy()->endOfMonth();

        $dates = collect();
        while ($start->lte($end)) {
            $dates->push($start->copy());
            $start->addDay();
        }

        return $table
            ->heading("Attendance Report ({$month->monthName})")
            ->query(
                fn () => Student::query()
                    ->whereBelongsTo($this->getOwnerRecord())
            )
            ->paginated(false)
            ->columns([
                TextColumn::make('name')
                    ->sortable(),
                TextColumn::make('surname')
                    ->sortable(['first_name']),
                TextColumn::make('attendances.attendance_status'),
                ...$dates->map(
                    fn (Carbon $date, $index) => TextColumn::make("attendance_{$index}")
                        ->label($date->day)
                        ->getStateUsing(function (Student $student) use ($date) {
                            if ($date->isSunday()) {
                                return '|';
                            }

                            $attendance = $student->attendances->where('date', $date)->first();

                            return $attendance ? $attendance->attendance_status : '-';
                        })
                        ->weight(fn () => $date->isSunday() ? FontWeight::Normal : FontWeight::SemiBold)
                        ->formatStateUsing(fn ($state) => $state instanceof AttendanceStatus ? $state->getShortLabel() : $state)
                )->toArray(),
            ])
            ->filters([
                Filter::make('month')
                    ->form([
                        Select::make('month')
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
                            ->default(now()->month),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        $selectedMonth = $data['month'] ?? now()->month;
                        $this->month = (int) $selectedMonth;

                        return $query->with(['attendances' => fn ($q) => $q->whereMonth('date', $selectedMonth)->whereYear('date', now()->year)]);
                    })
                    ->indicateUsing(function (array $data): ?string {
                        if ($data['month'] ?? null) {
                            return 'Month: ' . collect([
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
                            ])[$data['month']];
                        }

                        return null;
                    }),
            ]);
    }
}

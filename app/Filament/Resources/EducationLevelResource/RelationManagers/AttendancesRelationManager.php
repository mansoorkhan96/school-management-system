<?php

namespace App\Filament\Resources\EducationLevelResource\RelationManagers;

use App\Enums\AttendanceStatus;
use App\Filament\Resources\EducationLevelResource;
use App\Models\Student;
use Filament\Actions\Action;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Url;

class AttendancesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendances';

    #[Url]
    public ?int $month = null;

    public function table(Table $table): Table
    {
        $month = Carbon::createFromDate(now()->year, $this->month, 1);

        return $table
            ->heading("Attendance Report ({$month->monthName})")
            ->query(
                fn () => Student::query()
                    ->whereBelongsTo($this->getOwnerRecord())
                    ->with(['attendances' => fn ($query) => $query->whereMonth('date', $this->month)])
            )
            ->paginated(false)
            ->columns([
                TextColumn::make('name')
                    ->sortable(),
                TextColumn::make('surname')
                    ->sortable(['first_name']),
                ...$this->getAttendanceColumns(),
            ])
            ->headerActions([
                Action::make('filter')
                    ->icon(Heroicon::OutlinedFunnel)
                    ->schema([
                        ToggleButtons::make('month')
                            ->inline()
                            ->hiddenLabel()
                            ->options(self::getMonthOptions())
                            ->default($this->month ?? now()->month),
                    ])
                    ->action(function (array $data) {
                        $url = EducationLevelResource::getUrl('edit', [
                            'record' => $this->getOwnerRecord(),
                            'month' => $data['month'],
                        ]);

                        $this->redirect($url, true);
                    }),
            ]);
    }

    protected function getAttendanceColumns(): array
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

        return $dates
            ->map(
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
            )
            ->toArray();
    }

    protected static function getMonthOptions(): array
    {
        return [
            1 => 'Jan',
            2 => 'Feb',
            3 => 'Mar',
            4 => 'Apr',
            5 => 'May',
            6 => 'Jun',
            7 => 'Jul',
            8 => 'Aug',
            9 => 'Sep',
            10 => 'Oct',
            11 => 'Nov',
            12 => 'Dec',
        ];
    }
}

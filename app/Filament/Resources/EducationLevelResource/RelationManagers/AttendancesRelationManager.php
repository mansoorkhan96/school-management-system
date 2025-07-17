<?php

namespace App\Filament\Resources\EducationLevelResource\RelationManagers;

use App\Enums\AttendanceStatus;
use App\Filament\Resources\EducationLevelResource;
use App\Models\Attendance;
use App\Models\Student;
use Filament\Actions\Action;
use Filament\Forms\Components\ToggleButtons;
use Filament\Notifications\Notification;
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
            ->map(function (Carbon $date, $index) {
                $attendance = $date->isSunday()
                    ? '|'
                    : $this->getOwnerRecord()->attendances->where('date', $date)->value('attendance_status') ?? '-';

                return TextColumn::make("attendance_{$index}")
                    ->label($date->day)
                    ->getStateUsing(fn () => $attendance)
                    ->weight(fn () => $date->isSunday() ? FontWeight::Normal : FontWeight::SemiBold)
                    ->formatStateUsing(fn ($state) => $state instanceof AttendanceStatus ? $state->getShortLabel() : $state)
                    ->disabledClick(fn () => $attendance === '|' || $attendance === '-')
                    ->action(
                        // TODO: Bug, this action updates attendances for all students
                        // Maybe redirect to a page where attendance for specific date and level can be updated
                        Action::make('edit' . $date->toDateString() . $index)
                            ->modalHeading("Edit Attendance for {$date->format('d M Y')}")
                            ->schema([
                                ToggleButtons::make('attendance_status')
                                    ->options(AttendanceStatus::class)
                                    ->default($attendance)
                                    ->inline()
                                    ->required(),
                            ])
                            ->action(function (Student $student, array $data) use ($date) {
                                Attendance::query()
                                    ->whereBelongsTo($student)
                                    ->whereBelongsTo($this->getOwnerRecord())
                                    ->where('date', $date)
                                    ->update([
                                        'attendance_status' => $data['attendance_status'],
                                    ]);

                                Notification::make()
                                    ->success()
                                    ->title('Attendance updated!')
                                    ->send();
                            })
                    );
            })
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

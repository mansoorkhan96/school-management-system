<?php

namespace App\Filament\Resources\EducationLevels\Pages;

use App\Enums\AttendanceStatus;
use App\Filament\Resources\EducationLevels\EducationLevelResource;
use App\Models\Attendance;
use App\Models\Student;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Schema;
use Illuminate\Support\Carbon;

class TakeAttendance extends Page
{
    use InteractsWithRecord;
    use InteractsWithSchemas;

    protected static string $resource = EducationLevelResource::class;

    protected string $view = 'filament.education-levels.pages.take-attendance';

    public ?array $data = [];

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->form->fill([
            'date' => now(),
            'attendances' => $this->record
                ->students()
                ->get(['id', 'first_name', 'last_name', 'surname'])
                ->map(fn (Student $student) => [
                    'student_id' => $student->getKey(),
                    'name' => $student->name,
                    'attendance_status' => AttendanceStatus::Present,
                ]),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->state($this->data)
            ->schema([
                DatePicker::make('date')
                    ->native(false)
                    ->required()
                    ->rule(function ($operation) {
                        if (str_starts_with($operation, 'edit')) {
                            return;
                        }

                        return function (string $attribute, $value, \Closure $fail) {
                            $exists = Attendance::query()
                                ->whereBelongsTo($this->record)
                                ->whereDate('date', Carbon::parse($value)->toDateString())
                                // ->where('subject_id', 0)
                                ->exists();

                            $date = Carbon::parse($value)->format('M j, Y');
                            if ($exists) {
                                $fail("Attendance already exists for {$date}");
                            }
                        };
                    }),
                Repeater::make('attendances')
                    ->table([
                        TableColumn::make('Name')
                            ->alignLeft(),
                        TableColumn::make('Attendance')
                            ->alignLeft(),
                    ])
                    ->schema([
                        Hidden::make('student_id'),
                        Hidden::make('name'),
                        TextEntry::make('name')
                            ->hiddenLabel()
                            ->state(fn (Get $get) => $get('name'))
                            ->columnSpanFull(),
                        ToggleButtons::make('attendance_status')
                            ->options(AttendanceStatus::class)
                            ->inline(),
                    ])
                    ->addable(false)
                    ->deletable(false)
                    ->reorderable(false),
            ]);
    }

    public function submitAction(): Action
    {
        return Action::make('submit')
            ->button()
            ->action(function () {
                $date = $this->form->getState()['date'];

                $data = array_map(fn ($item) => [
                    'student_id' => $item['student_id'],
                    'attendance_status' => $item['attendance_status'],
                    'date' => $date,
                ], $this->form->getState()['attendances']);

                $this->record->attendances()->createMany($data);

                Notification::make()
                    ->success()
                    ->title('Attendance submitted!')
                    ->send();

                return redirect($this->getResource()::getUrl('edit', ['record' => $this->record]));
            });
    }
}

<?php

namespace App\Filament\Resources\EducationLevelResource\Pages;

use App\Enums\AttendanceStatus;
use App\Filament\Resources\EducationLevelResource;
use App\Models\Student;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Icetalker\FilamentTableRepeater\Forms\Components\TableRepeater;

class TakeAttendance extends Page
{
    use InteractsWithRecord;

    protected static string $resource = EducationLevelResource::class;

    protected static string $view = 'filament.resources.education-level-resource.pages.take-attendance';

    public array $data = [];

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->form->fill([
            'date' => now(),
            'attendances' => $this->record->students()->get(['id', 'first_name', 'last_name', 'surname'])->map(fn (Student $student) => [
                'student_id' => $student->getKey(),
                'name' => $student->name,
                'attendance_status' => AttendanceStatus::Present->value,
            ]),
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                DatePicker::make('date')
                    ->native(false)
                    ->required(),
                TableRepeater::make('attendances')
                    ->schema([
                        Hidden::make('student_id'),
                        Placeholder::make('name')
                            ->content(fn (Get $get) => $get('name'))
                            ->columnSpanFull(),
                        ToggleButtons::make('attendance_status')
                            ->options(AttendanceStatus::class)
                            ->inline(),
                    ])
                    ->hiddenLabel()
                    ->deletable(false)
                    ->reorderable(false)
                    ->addable(false)
                    ->columnSpan('full'),
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

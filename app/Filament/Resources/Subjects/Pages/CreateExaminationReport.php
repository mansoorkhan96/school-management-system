<?php

namespace App\Filament\Resources\Subjects\Pages;

use App\Enums\ExaminationReportType;
use App\Filament\Resources\Subjects\SubjectResource;
use App\Models\ExaminationReport;
use App\Models\Student;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Schema;

class CreateExaminationReport extends Page
{
    use InteractsWithRecord;
    use InteractsWithSchemas;

    protected static string $resource = SubjectResource::class;

    protected string $view = 'filament.subjects.pages.create-examination-report';

    public ?array $data = [];

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);

        $this->form->fill([
            'year' => now()->year,
            'type' => ExaminationReportType::class,
            'examination_reports' => $this->record
                ->educationLevel
                ->students()
                ->get(['id', 'first_name', 'last_name', 'surname'])
                ->map(fn (Student $student) => [
                    'student_id' => $student->getKey(),
                    'name' => $student->name,
                    'obtained_marks' => 0,
                ]),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->columns(2)
            ->schema([
                Select::make('type')
                    ->options(ExaminationReportType::class)
                    ->required(),
                TextInput::make('year')
                    ->numeric()
                    ->default(now()->year)
                    ->required()
                    ->rule(function ($operation, $state, Get $get) {
                        if (str_starts_with($operation, 'edit')) {
                            return;
                        }

                        return function (string $attribute, $value, \Closure $fail) use ($state, $get) {
                            $exists = ExaminationReport::query()
                                ->whereBelongsTo($this->record)
                                ->where('education_level_id', $this->record->educationLevel->getKey())
                                ->where('type', $get('type'))
                                ->where('year', $state)
                                ->exists();

                            if ($exists) {
                                $fail("Examination report already exists for {$get('type')->getLabel()} {$state}");
                            }
                        };
                    }),
                Repeater::make('examination_reports')
                    ->columnSpanFull()
                    ->table([
                        TableColumn::make('Name')
                            ->alignLeft(),
                        TableColumn::make('Marks')
                            ->alignLeft(),
                    ])
                    ->schema([
                        Hidden::make('student_id'),
                        Hidden::make('name'),
                        TextEntry::make('name')
                            ->hiddenLabel()
                            ->state(fn (Get $get) => $get('name'))
                            ->columnSpanFull(),
                        TextInput::make('obtained_marks')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue($this->record->max_marks)
                            ->required(),
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
                $formData = $this->form->getState();

                $data = array_map(fn ($item) => [
                    'student_id' => $item['student_id'],
                    'education_level_id' => $this->record->educationLevel->getKey(),
                    'type' => $formData['type'],
                    'year' => $formData['year'],
                    'obtained_marks' => $item['obtained_marks'],
                ], $formData['examination_reports']);

                $this->record->examinationReports()->createMany($data);

                Notification::make()
                    ->success()
                    ->title('Examination reports submitted!')
                    ->send();

                return redirect($this->getResource()::getUrl('edit', ['record' => $this->record]));
            });
    }
}

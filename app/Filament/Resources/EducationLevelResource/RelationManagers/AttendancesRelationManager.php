<?php

namespace App\Filament\Resources\EducationLevelResource\RelationManagers;

use App\Enums\AttendanceStatus;
use App\Models\Student;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class AttendancesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendances';

    public function table(Table $table): Table
    {
        $month = now();
        $start = $month->copy()->startOfMonth();
        $end = $month->copy()->endOfMonth();

        $dates = collect();
        while ($start->lte($end)) {
            $dates->push($start->toDateString());
            $start->addDay();
        }

        return $table
            ->query(Student::query()->where('education_level_id', $this->getOwnerRecord()->getKey()))
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('surname')
                    ->sortable(),
                ...$dates->map(fn ($date, $index) => Tables\Columns\TextColumn::make("attendance_{$index}")
                    ->label(Carbon::parse($date)->format('d'))
                    ->getStateUsing(function (Student $record) use ($date) {
                        $attendance = $record->attendances()->whereDate('date', $date)->first();

                        return $attendance ? $attendance->attendance_status : '-';
                    })
                    ->weight(FontWeight::SemiBold)
                    ->formatStateUsing(fn ($state) => $state instanceof AttendanceStatus ? $state->getShortLabel() : $state)
                )->toArray(),
            ])
            ->filters([
                // Tables\Filters\SelectFilter::make('level')
                //     ->relationship('level', 'name')
                //     ->label('Education Level'),
                // Add more filters as needed
            ]);
    }
}

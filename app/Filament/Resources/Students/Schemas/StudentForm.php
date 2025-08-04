<?php

namespace App\Filament\Resources\Students\Schemas;

use App\Enums\BloodGroup;
use App\Enums\Gender;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Group::make([
                    Section::make('Student Details')
                        ->columns(2)
                        ->components([
                            TextInput::make('first_name')
                                ->required(),
                            TextInput::make('last_name')
                                ->required(),
                            TextInput::make('surname')
                                ->required(),
                            Select::make('gender')
                                ->options(Gender::class)
                                ->required(),
                            DatePicker::make('date_of_birth'),
                            Select::make('blood_group')
                                ->options(BloodGroup::class),
                            TextInput::make('religion'),
                            TextInput::make('nationality'),
                            TextInput::make('languages_known'),
                            TextInput::make('mother_tongue'),
                            Textarea::make('address')
                                ->columnSpanFull(),
                        ]),
                    Section::make('Guardian Details')
                        ->columns(2)
                        ->components([
                            TextInput::make('family_no'),
                            TextInput::make('father_name'),
                            TextInput::make('father_cnic'),
                            TextInput::make('mother_name'),
                            TextInput::make('mother_cnic'),
                            TextInput::make('phone')
                                ->tel(),
                        ]),
                    Section::make('Student Health Details')
                        ->columns(2)
                        ->components([
                            Toggle::make('has_disability'),
                            Toggle::make('has_doctor_consultancy'),
                            Textarea::make('disease')
                                ->columnSpanFull(),
                            Textarea::make('medication')
                                ->columnSpanFull(),
                        ]),
                ])
                    ->columnSpan(2),
                Group::make([
                    Section::make('Student Academic Details')
                        ->components([
                            Flex::make([
                                FileUpload::make('profile_photo_path')
                                    ->label('Profile Photo')
                                    ->image()
                                    ->directory('profile-photos')
                                    ->disk('public')
                                    ->avatar()
                                    ->grow(false),
                            ])->extraAttributes(['style' => 'justify-content: center;']),
                            Toggle::make('is_active')
                                ->required(),
                            TextInput::make('registery_number')
                                ->required(),

                            DatePicker::make('admission_date')
                                ->required(),
                            Select::make('initial_education_level_id')
                                ->relationship('initialEducationLevel', 'name')
                                ->required(),
                            Select::make('education_level_id')
                                ->relationship('educationLevel', 'name')
                                ->required(),

                            DatePicker::make('school_leaving_date'),
                            Select::make('previous_education_level_id')
                                ->relationship('previousEducationLevel', 'name'),
                            TextInput::make('previous_study_year'),
                            TextInput::make('previous_school_name'),
                            TextInput::make('previous_level_marks')
                                ->numeric(),
                        ]),
                ]),

            ]);
    }
}
<?php

namespace App\Filament\Resources;

use App\Enums\BloodGroup;
use App\Filament\Resources\StudentResource\Pages\CreateStudent;
use App\Filament\Resources\StudentResource\Pages\EditStudent;
use App\Filament\Resources\StudentResource\Pages\ListStudents;
use App\Models\Student;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-users';

    public static function form(Schema $schema): Schema
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
                            TextInput::make('gender')
                                ->required(),
                            DatePicker::make('date_of_birth'),
                            Select::make('blood_group')
                                ->options(BloodGroup::class),
                            TextInput::make('religion'),
                            TextInput::make('nationality'),
                            Textarea::make('address')
                                ->columnSpanFull(),
                            TextInput::make('languages_known'),
                            TextInput::make('mother_tongue'),
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
                        ->components([
                            Toggle::make('has_disability')
                                ->required(),
                            Textarea::make('disease')
                                ->columnSpanFull(),
                            Textarea::make('medication')
                                ->columnSpanFull(),
                            Toggle::make('has_doctor_consultancy')
                                ->required(),
                        ]),
                ])
                    ->columnSpan(2),
                Group::make([
                    Section::make('Student Academic Details')
                        ->components([
                            Flex::make([
                                FileUpload::make('profile_photo_path')
                                    ->image()
                                    ->directory('profile-photos')
                                    ->disk('public')
                                    ->avatar()
                                    ->hiddenLabel()
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('profile_photo_path')
                    ->circular()
                    ->disk('public')
                    ->label('Photo'),
                TextColumn::make('registery_number')
                    ->searchable(),
                TextColumn::make('first_name')
                    ->searchable(),
                TextColumn::make('last_name')
                    ->searchable(),
                TextColumn::make('surname')
                    ->searchable(),
                TextColumn::make('educationLevel.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('gender')
                    ->searchable(),
                TextColumn::make('initialEducationLevel.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('admission_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('date_of_birth')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('blood_group')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('religion')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('nationality')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('family_no')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('languages_known')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('mother_tongue')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('school_leaving_date')
                    ->date()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('father_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('father_cnic')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('mother_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('mother_cnic')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('previousEducationLevel.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('previous_study_year')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('previous_school_name')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('previous_level_marks')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('has_disability')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('has_doctor_consultancy')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_active')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudents::route('/'),
            'create' => CreateStudent::route('/create'),
            'edit' => EditStudent::route('/{record}/edit'),
        ];
    }
}

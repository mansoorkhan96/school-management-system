<?php

namespace App\Filament\Resources\Fees;

use App\Filament\Resources\Fees\Pages\CreateFees;
use App\Filament\Resources\Fees\Pages\EditFees;
use App\Filament\Resources\Fees\Pages\ListFees;
use App\Filament\Resources\Fees\Schemas\FeesForm;
use App\Filament\Resources\Fees\Tables\FeesTable;
use App\Models\Fees;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class FeesResource extends Resource
{
    protected static ?string $model = Fees::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return FeesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FeesTable::configure($table);
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
            'index' => ListFees::route('/'),
            'create' => CreateFees::route('/create'),
            'edit' => EditFees::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::whereNull('payment_date')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getNavigationBadge() > 0 ? 'warning' : 'success';
    }
}

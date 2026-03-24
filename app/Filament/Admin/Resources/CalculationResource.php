<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CalculationResource\Pages;
use App\Models\Calculation;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CalculationResource extends Resource
{
    protected static ?string $model = Calculation::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';
    protected static ?int $navigationSort = 0;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('ID Klienta')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produkt')
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('summary.final_price')
                    ->label('Kwota')
                    ->alignRight()
                    ->formatStateUsing(
                        fn ($state) => $state ? number_format((float)$state, 2, ',', ' ') . ' zł' : '-'
                    ),

                Tables\Columns\TextColumn::make('summary.discount')
                    ->label('Rabat')
                    ->alignRight()
                    ->formatStateUsing(
                        fn ($state) => $state && (float)$state > 0 ? number_format((float)$state, 2, ',', ' ') . ' zł' : '-'
                    ),

                Tables\Columns\IconColumn::make('is_read')
                    ->label('Przeczytane')
                    ->boolean()
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data wygenerowania')
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\Filter::make('Nieprzeczytane')
                    ->query(fn ($query) => $query->where('is_read', false)),
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->label('Pobierz PDF')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('gray')
                    ->url(fn ($record) => route('admin.calculation.download', $record)) // własna trasa
                    ->openUrlInNewTab()
                    ->tooltip('Pobierz plik PDF'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCalculations::route('/'),
        ];
    }

    public static function getModelLabel(): string
    {
        return __('Wycena');
    }

    public static function getPluralModelLabel(): string
    {
        return __('Wyceny');
    }

    public static function getNavigationBadge(): ?string
    {
        $count = Calculation::where('is_read', false)->count();

        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }
}

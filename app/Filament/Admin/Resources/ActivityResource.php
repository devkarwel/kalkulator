<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ActivityResource\Pages;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;

class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;
    protected static ?string $navigationIcon = 'heroicon-m-magnifying-glass-circle';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('causer.name')
                    ->label('Użytkownik')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Opis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivities::route('/'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Aktywność';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Aktywności';
    }
}

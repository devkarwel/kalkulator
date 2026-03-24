<?php

namespace App\Filament\Admin\Resources\PriceRangeResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class StepsRelationManager extends RelationManager
{
    protected static string $relationship = 'steps';
    protected static ?string $title = 'Przedziały cenowe';
    protected static ?string $recordTitleAttribute = 'price';

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                    Forms\Components\TextInput::make('min_width')
                        ->label('Szer. od')
                        ->numeric()
                        ->required(),
                    Forms\Components\TextInput::make('max_width')
                        ->label('Szer. do')
                        ->numeric()
                        ->required(),
                    Forms\Components\TextInput::make('min_height')
                        ->label('Wys. od')
                        ->numeric()
                        ->required(),
                    Forms\Components\TextInput::make('max_height')
                        ->label('Wys. do')
                        ->numeric()
                        ->required(),
                    Forms\Components\TextInput::make('price')
                        ->label('Cena')
                        ->numeric()
                        ->required(),

            ])
            ->columns(['sm' => 2, 'md' => 5]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('price')
            ->columns([
                Tables\Columns\TextColumn::make('min_width')
                    ->label('Szer. od')
                    ->numeric(2, '.', ' ')
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_width')
                    ->label('Szer. do')
                    ->numeric(2, '.', ' ')
                    ->sortable(),
                Tables\Columns\TextColumn::make('min_height')
                    ->label('Wys. od')
                    ->numeric(2, '.', ' ')
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_height')
                    ->label('Wys. do')
                    ->numeric(2, '.', ' ')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Cena')
                    ->numeric(2, '.', ' ')
                    ->suffix(' zł')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}

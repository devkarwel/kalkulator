<?php

namespace App\Filament\Admin\Resources\PriceRangeResource\RelationManagers;

use App\Enums\PriceActionModifier;
use App\Enums\PriceTypeModifier;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ModifiersRelationManager extends RelationManager
{
    protected static string $relationship = 'modifiers';
    protected static ?string $title = 'Modyfikatory cenowe';
    protected static ?string $recordTitleAttribute = 'id';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\Select::make('attribute_id')
                            ->label(__('Atrybut'))
                            ->relationship('attribute', 'label')
                            ->preload(),

                        Forms\Components\Select::make('attribute_value_id')
                            ->label(__('Wartość atrybutu'))
                            ->relationship('attributeValue', 'label')
                            ->preload(),
                    ]),

                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Select::make('action')
                            ->label(__('Działanie'))
                            ->options(PriceActionModifier::class)
                            ->reactive()
                            ->required(),

                        Forms\Components\Select::make('type')
                            ->label(__('Typ'))
                            ->options(PriceTypeModifier::class)
                            ->reactive()
                            ->required(),

                        Forms\Components\TextInput::make('value')
                            ->label(__('Wartość'))
                            ->reactive()
                            ->numeric()
                            ->minValue(0)
                            ->prefix(fn (Forms\Get $get) => match($get('action')) {
                                PriceActionModifier::ADD->value => '+',
                                PriceActionModifier::SUBTRACT->value => '-',
                                default => null,
                            })
                            ->suffix(fn (Forms\Get $get) => match($get('type')) {
                                PriceTypeModifier::PERCENT->value => '%',
                                PriceTypeModifier::AMOUNT->value => 'PLN',
                                default => null,
                            })
                            ->required(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('attribute.label')
                    ->label(__('Atrybut')),

                Tables\Columns\TextColumn::make('attributeValue.label')
                    ->label(__('Wartość atrybutu')),

                Tables\Columns\TextColumn::make('action')
                    ->label(__('Działanie')),

                Tables\Columns\TextColumn::make('type')
                    ->label(__('Typ')),

                Tables\Columns\TextColumn::make('value')
                    ->label(__('Wartość')),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

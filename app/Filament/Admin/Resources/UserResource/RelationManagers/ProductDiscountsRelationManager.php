<?php

namespace App\Filament\Admin\Resources\UserResource\RelationManagers;

use App\Enums\PriceTypeModifier;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ProductDiscountsRelationManager extends RelationManager
{
    protected static string $relationship = 'productDiscounts';
    protected static ?string $title = 'Udzielone rabaty';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->label('Produkt')
                    ->options(fn () => Product::orderBy('name')->pluck('name', 'id'))
                    ->reactive()
                    ->required()
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        $set('discount_type', null);
                        $set('discount_value', null);
                    }),

                Forms\Components\Select::make('discount_type')
                    ->label('Typ rabatu')
                    ->options(PriceTypeModifier::class)
                    ->reactive()
                    ->required()
                    ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('discount_value', null)),

                Forms\Components\TextInput::make('discount_value')
                    ->label('Wartość rabatu')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(fn (callable $get) => match ($get('discount_type')) {
                        PriceTypeModifier::AMOUNT->value => 99999,
                        PriceTypeModifier::PERCENT->value => 100,
                        default => null,
                    })
                    ->suffix(fn (callable $get) => match ($get('discount_type')) {
                        PriceTypeModifier::AMOUNT->value => 'PLN',
                        PriceTypeModifier::PERCENT->value => '%',
                        default => null,
                    })
                    ->placeholder(fn (callable $get) => match ($get('discount_type')) {
                        PriceTypeModifier::AMOUNT->value => 'rabat kwotowy',
                        PriceTypeModifier::PERCENT->value => 'rabat procentowy',
                        default => 'brak',
                    })
                    ->default(null)
                    ->required(fn (Forms\Get $get) => $get('discount_type') !== null),
            ])
            ->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('product.name')
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produkt')
                    ->sortable(),

                Tables\Columns\TextColumn::make('discount_type')
                    ->label('Typ rabatu'),

                Tables\Columns\TextColumn::make('discount_value')
                    ->label('Wartość rabatu')
                    ->formatStateUsing(fn ($state, $record) => match ($record->discount_type) {
                        PriceTypeModifier::AMOUNT => number_format($state, 2, '.', ' ') . ' PLN',
                        PriceTypeModifier::PERCENT => number_format($state, 2, '.', ' ') . ' %',
                        default => null,
                    }),
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

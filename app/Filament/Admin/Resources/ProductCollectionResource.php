<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ProductCollectionResource\Pages;
use App\Filament\Admin\Resources\ProductCollectionResource\RelationManagers;
use App\Models\Product;
use App\Models\ProductCollection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductCollectionResource extends Resource
{
    protected static ?string $model = ProductCollection::class;
    protected static ?string $navigationIcon = 'heroicon-s-bars-4';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Hidden::make('name'),

                        Forms\Components\Select::make('product_id')
                            ->label('Produkt')
                            ->relationship('product', 'name')
                            ->reactive()
                            ->required(),

                        Forms\Components\TextInput::make('label')
                            ->label(__('Etykieta'))
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $old, ?string $state) {
                                if (
                                    blank($get('name')) || $get('name') === Str::slug($old)
                                ) {
                                    $set('name', Str::slug($state));
                                }
                            }),
                    ])
                    ->columns(['sm' => 1, 'md' => 2]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('label')->label('Etykieta'),

                Tables\Columns\TextColumn::make('product.name')
                    ->label('Produkt'),

                Tables\Columns\TextColumn::make('items_count')
                    ->counts('items')
                    ->label('Liczba elementów')
                    ->badge()
                    ->color(fn (int $state): string => $state > 0 ? 'success' : 'warning'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('product_id')
                    ->label('Produkt')
                    ->options(
                        Product::all()->pluck('name', 'id')
                    )
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductCollections::route('/'),
            'create' => Pages\CreateProductCollection::route('/create'),
            'edit' => Pages\EditProductCollection::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Kolekcja';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Kolekcje';
    }
}

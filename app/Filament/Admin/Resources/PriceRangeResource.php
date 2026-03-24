<?php

namespace App\Filament\Admin\Resources;

use App\Enums\AttributeInputType;
use App\Filament\Admin\Resources\PriceRangeResource\Pages;
use App\Filament\Admin\Resources\PriceRangeResource\RelationManagers;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\PriceRange;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\ProductCollectionItem;
use App\Models\ProductCollectionItemValue;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PriceRangeResource extends Resource
{
    protected static ?string $model = PriceRange::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nazwa cennika')
                            ->required(),

                        Forms\Components\Repeater::make('conditions')
                            ->label('Warunki przypisania')
                            ->addActionLabel('Dodaj zależność')
                            ->relationship('conditions')
                            ->schema([
                                Forms\Components\Grid::make()
                                    ->schema([
                                        Forms\Components\Select::make('product_id')
                                            ->label('Produkt')
                                            ->relationship('product', 'name')
                                            ->required()
                                            ->reactive()
                                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('attribute_id', null)),

                                        Forms\Components\Select::make('attribute_id')
                                            ->label('Atrybut (opcjonalnie)')
                                            ->options(
                                                fn (callable $get) =>
                                                    Attribute::query()
                                                        ->where('product_id', $get('product_id'))
                                                        ->pluck('label', 'id')
                                            )
                                            ->nullable()
                                            ->reactive()
                                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('attribute_value_id', [])),

                                        Forms\Components\CheckboxList::make('attributeValues')
                                            ->label('Wartości atrybutu (opcjonalnie)')
                                            ->relationship('attributeValues', 'label')
                                            ->options(
                                                fn (callable $get) =>
                                                    AttributeValue::where('attribute_id', $get('attribute_id'))
                                                        ->pluck('label', 'id')
                                            )
                                            ->visible(fn (callable $get) => filled($get('attribute_id')) && optional(Attribute::find($get('attribute_id')))->input_type !== AttributeInputType::COLLECTION)
                                            ->columns(4)
                                            ->columnSpanFull()
                                            ->nullable(),

                                        Forms\Components\Select::make('product_collection_id')
                                            ->label('Kolekcja')
                                            ->options(ProductCollection::pluck('label', 'id'))
                                            ->reactive()
                                            ->visible(fn (callable $get) => optional(Attribute::find($get('attribute_id')))->input_type === AttributeInputType::COLLECTION),

                                        Forms\Components\Select::make('product_collection_item_id')
                                            ->label('Element kolekcji')
                                            ->options(
                                                fn (callable $get) =>
                                                    ProductCollectionItem::where('product_collection_id', $get('product_collection_id'))
                                                        ->pluck('label', 'id')
                                            )
                                            ->reactive()
                                            ->visible(fn (callable $get) => filled($get('product_collection_id'))),

                                        Forms\Components\Select::make('product_collection_item_value_id')
                                            ->label('Wartość elementu kolekcji')
                                            ->options(
                                                fn (callable $get) =>
                                                    ProductCollectionItemValue::where('product_collection_item_id', $get('product_collection_item_id'))
                                                        ->pluck('label', 'id')
                                            )
                                            ->visible(fn (callable $get) => filled($get('product_collection_item_id'))),
                                    ]),
                            ])
                            ->defaultItems(1)
                            ->columns(1),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nazwa')
                    ->searchable(),
                Tables\Columns\TextColumn::make('conditions.product.name')
                    ->label('Produkt')
                    ->searchable(),
                Tables\Columns\TextColumn::make('steps_count')
                    ->counts('steps')
                    ->label('Ilość przedziałów'),
                Tables\Columns\TextColumn::make('conditions_count')
                    ->counts('conditions')
                    ->label('Ilość warunków'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('product_id')
                    ->label('Produkt')
                    ->relationship(
                        name: 'conditions.product',
                        titleAttribute: 'name',
                    )
                    ->options(
                        fn () => Product::orderBy('name')->pluck('name', 'id')->toArray()
                    ),
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
            RelationManagers\StepsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPriceRanges::route('/'),
            'create' => Pages\CreatePriceRange::route('/create'),
            'edit' => Pages\EditPriceRange::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Cennik';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Cenniki';
    }
}

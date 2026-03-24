<?php

namespace App\Filament\Admin\Resources\AttributeValueResource\RelationManagers;

use App\Enums\AttributeInputType;
use App\Enums\PriceActionModifier;
use App\Enums\PriceTypeModifier;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\ProductCollectionItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PriceModifiersRelationManager extends RelationManager
{
    protected static string $relationship = 'priceModifiers';
    protected static ?string $title = 'Dopłaty cenowe';
    protected static ?string $recordTitleAttribute = 'id';

    public function form(Form $form): Form
    {
        /** @var AttributeValue $attributeValue */
        $attributeValue = $this->getOwnerRecord();
        $product = $attributeValue->attribute->product;

        return $form
            ->schema([
                Forms\Components\Grid::make(3)
                    ->schema([
                        Forms\Components\Select::make('action')
                            ->label(__('Działanie'))
                            ->options(PriceActionModifier::class)
                            ->reactive()
                            ->required()
                            ->default(PriceActionModifier::ADD->value),

                        Forms\Components\Select::make('type')
                            ->label(__('Typ'))
                            ->options(PriceTypeModifier::class)
                            ->reactive()
                            ->required()
                            ->default(PriceTypeModifier::AMOUNT->value),

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

                        Forms\Components\Toggle::make('multiply_by_quantity')
                            ->label(__('Za sztukę'))
                            ->helperText('Włącz jeśli dopłata ma być mnożona przez ilość sztuk')
                            ->default(false),
                    ]),

                Forms\Components\Section::make('Warunki (opcjonalnie)')
                    ->description('Jeśli nie dodasz żadnych warunków, dopłata będzie zawsze doliczana do tej wartości atrybutu.')
                    ->schema([
                        Forms\Components\Repeater::make('conditions')
                            ->relationship('conditions')
                            ->schema([
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\Select::make('product_id')
                                            ->label('Produkt')
                                            ->options(
                                                fn () => Product::orderBy('name')->pluck('name', 'id')->toArray()
                                            )
                                            ->default($product->id)
                                            ->nullable()
                                            ->reactive()
                                            ->afterStateUpdated(fn (Forms\Set $set) => $set('attribute_id', null)),

                                        Forms\Components\Select::make('attribute_id')
                                            ->label('Atrybut (opcjonalnie)')
                                            ->options(
                                                fn (callable $get) =>
                                                    Attribute::query()
                                                        ->where('product_id', $get('product_id') ?? $product->id)
                                                        ->where('input_type', '!=', AttributeInputType::COLLECTION)
                                                        ->pluck('label', 'id')
                                            )
                                            ->nullable()
                                            ->reactive()
                                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('attributeValues', [])),

                                        Forms\Components\CheckboxList::make('attributeValues')
                                            ->label('Wartości atrybutu (opcjonalnie)')
                                            ->relationship('attributeValues', 'label')
                                            ->options(
                                                fn (callable $get) =>
                                                    AttributeValue::where('attribute_id', $get('attribute_id'))
                                                        ->pluck('label', 'id')
                                            )
                                            ->visible(fn (callable $get) => filled($get('attribute_id')))
                                            ->columns(4)
                                            ->columnSpanFull()
                                            ->nullable(),

                                        Forms\Components\Select::make('product_collection_id')
                                            ->label('Kolekcja (opcjonalnie)')
                                            ->options(
                                                fn (callable $get) =>
                                                    ProductCollection::query()
                                                        ->where('product_id', $get('product_id') ?? $product->id)
                                                        ->orderBy('label')
                                                        ->pluck('label', 'id')
                                            )
                                            ->nullable()
                                            ->reactive()
                                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                                $set('product_collection_item_id', null);
                                                $set('product_collection_item_value_id', null);
                                            }),

                                        Forms\Components\Select::make('product_collection_item_id')
                                            ->label('Element kolekcji (opcjonalnie)')
                                            ->options(
                                                fn (callable $get) =>
                                                    ProductCollectionItem::query()
                                                        ->where('product_collection_id', $get('product_collection_id'))
                                                        ->orderBy('label')
                                                        ->pluck('label', 'id')
                                            )
                                            ->nullable()
                                            ->reactive()
                                            ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('product_collection_item_value_id', null))
                                            ->visible(fn (callable $get) => filled($get('product_collection_id'))),

                                        Forms\Components\Select::make('product_collection_item_value_id')
                                            ->label('Wartość elementu kolekcji (opcjonalnie)')
                                            ->options(
                                                fn (callable $get) =>
                                                    \App\Models\ProductCollectionItemValue::query()
                                                        ->where('product_collection_item_id', $get('product_collection_item_id'))
                                                        ->orderBy('label')
                                                        ->pluck('label', 'id')
                                            )
                                            ->nullable()
                                            ->visible(fn (callable $get) => filled($get('product_collection_item_id'))),
                                    ]),
                            ])
                            ->defaultItems(0)
                            ->collapsible()
                            ->itemLabel(fn (array $state): string => 
                                'Warunek: ' . ($state['product_id'] ? Product::find($state['product_id'])?->name : 'Brak')
                            )
                            ->addActionLabel('Dodaj warunek')
                            ->columns(1),
                    ])
                    ->collapsible()
                    ->collapsed(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                Tables\Columns\TextColumn::make('action')
                    ->label(__('Działanie'))
                    ->badge()
                    ->color(fn ($state): string => match($state instanceof PriceActionModifier ? $state->value : $state) {
                        PriceActionModifier::ADD->value => 'success',
                        PriceActionModifier::SUBTRACT->value => 'danger',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('type')
                    ->label(__('Typ'))
                    ->badge(),

                Tables\Columns\TextColumn::make('value')
                    ->label(__('Wartość'))
                    ->formatStateUsing(function ($state, $record) {
                        $action = $record->action instanceof PriceActionModifier ? $record->action : PriceActionModifier::tryFrom($record->action);
                        $type = $record->type instanceof PriceTypeModifier ? $record->type : PriceTypeModifier::tryFrom($record->type);
                        
                        $prefix = match($action) {
                            PriceActionModifier::ADD => '+',
                            PriceActionModifier::SUBTRACT => '-',
                            default => '',
                        };
                        
                        $suffix = match($type) {
                            PriceTypeModifier::PERCENT => '%',
                            PriceTypeModifier::AMOUNT => ' zł',
                            default => '',
                        };
                        
                        return $prefix . number_format((float)$state, 2, ',', ' ') . $suffix;
                    }),

                Tables\Columns\TextColumn::make('multiply_by_quantity')
                    ->label(__('Za'))
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Za sztukę' : 'Jednorazowa')
                    ->color(fn (bool $state): string => $state ? 'info' : 'gray'),

                Tables\Columns\TextColumn::make('conditions_count')
                    ->label('Ilość warunków')
                    ->counts('conditions')
                    ->badge()
                    ->color(fn (int $state): string => $state > 0 ? 'warning' : 'success')
                    ->formatStateUsing(fn (int $state): string => $state > 0 ? "{$state} warunków" : 'Zawsze'),
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


<?php

namespace App\Filament\Admin\Resources;

use App\Enums\AttributeInputType;
use App\Filament\Admin\Resources\ProductResource\Pages;
use App\Filament\Admin\Resources\ProductResource\RelationManagers\AttributeDependenciesRelationManager;
use App\Filament\Admin\Resources\ProductResource\RelationManagers\AttributeRelationManager;
use App\Models\Attribute;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label(__('Aktywny'))
                            ->default(true)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('sort_order')
                            ->label(__('Kolejność wyświetlania'))
                            ->numeric()
                            ->default(1)
                            ->minValue(0)
                            ->required(),

                        Forms\Components\TextInput::make('name')
                            ->label(__('Nazwa produktu'))
                            ->placeholder(__('wyświetlana nazwa'))
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $old, ?string $state) {
                                if (($get('slug') ?? '') !== Str::slug($old)) {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            })
                            ->required(),

                        Forms\Components\TextInput::make('slug')
                            ->label(__('Slug'))
                            ->placeholder('url produktu - uzupełnione automatycznie')
                            ->readonly()
                            ->required()
                            ->rule(fn (Forms\Get $get, ?Product $record) => [
                                Rule::unique('products', 'slug')->ignore($record?->id),
                            ]),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('width_attribute')
                                    ->label('Atrybut szerokości')
                                    ->hintIcon('heroicon-c-question-mark-circle', 'wybierz który zdefiniowany atrybut odzwierciedla szerokość w cenniku')
                                    ->options(fn (?Product $product) => self::getAvailableInputs($product)),

                                Forms\Components\Select::make('height_attribute')
                                    ->label('Atrybut wysokości')
                                    ->hintIcon('heroicon-c-question-mark-circle', 'wybierz który zdefiniowany atrybut odzwierciedla wysokość w cenniku')
                                    ->options(fn (?Product $product) => self::getAvailableInputs($product)),

                                Forms\Components\Select::make('quantity_attribute')
                                    ->label('Atrybut Ilości')
                                    ->hintIcon('heroicon-c-question-mark-circle', 'wybierz który zdefiniowany atrybut odzwierciedla podaną ilość')
                                    ->options(fn (?Product $product) => self::getAvailableInputs($product)),
                            ])
                            ->columnSpanFull(),

                        Forms\Components\SpatieMediaLibraryFileUpload::make('cover')
                            ->label(__('Okładka'))
                            ->image()
                            ->collection('cover')
                            ->extraAttributes(['class' => 'custom-upload-preview'])
                            ->columnSpanFull(),
                    ]),
                ]),
            ]);
    }

    private static function getAvailableInputs(?Product $record): array
    {
        if (! $record) {
            return [];
        }

        // Pobierz atrybuty typu FIELD_INPUT i zwróć tablicę name => label
        return $record->attributes()
            ->where('input_type', AttributeInputType::FIELD_INPUT)
            ->get()
            ->flatMap(function (Attribute $attribute) {
                // Dla każdego atrybutu zwracamy jego wartości (pola tekstowe)
                return $attribute->values->mapWithKeys(function ($value) {
                    return [$value->name => $value->label];
                });
            })
            ->toArray();
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable()
                    ->label(__('Kolejność')),

                Tables\Columns\SpatieMediaLibraryImageColumn::make('cover')
                    ->collection('cover')
                    ->label(__('Okładka')),

                Tables\Columns\TextColumn::make('name')
                    ->label(__('Nazwa produktu')),

                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('Dodano'))
                    ->since()
                    ->dateTimeTooltip()
                    ->dateTime(),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label(__('Edycja'))
                    ->since()
                    ->dateTimeTooltip()
                    ->dateTime(),
            ])
            ->defaultSort('sort_order')
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
            AttributeRelationManager::class,
            AttributeDependenciesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Produkt';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Produkty';
    }
}

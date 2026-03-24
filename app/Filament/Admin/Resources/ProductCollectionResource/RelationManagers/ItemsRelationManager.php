<?php

namespace App\Filament\Admin\Resources\ProductCollectionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';
    protected static ?string $title = 'Elementy kolekcji';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('name'),
                Forms\Components\Hidden::make('value'),

                Forms\Components\Toggle::make('is_active')
                    ->label(__('Aktywny'))
                    ->default(true)
                    ->columnSpanFull()
                    ->helperText('Jeśli wyłączysz, element będzie widoczny ale niedostępny do wyboru. UWAGA: Przynajmniej jeden wariant musi być aktywny.'),

                Forms\Components\TextInput::make('label')
                    ->label('Etykieta')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $old, ?string $state) {
                        if (
                            blank($get('name')) || $get('name') === Str::slug($old)
                        ) {
                            $set('name', Str::slug($state));
                        }

                        if (
                            blank($get('value')) || $get('value') === Str::slug($old)
                        ) {
                            $set('value', Str::slug($state));
                        }
                    }),

                Forms\Components\TextInput::make('sort_order')
                    ->label(__('Kolejność'))
                    ->hint('pozycja w kolekcji')
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(99)
                    ->default(1)
                    ->step(1),

                Forms\Components\SpatieMediaLibraryFileUpload::make('collection_item')
                    ->label(__('Grafika elementu'))
                    ->collection('collection_item')
                    ->extraAttributes(['class' => 'custom-upload-preview'])
                    ->columnSpanFull(),

                Forms\Components\Repeater::make('values')
                    ->label(__('Elementy'))
                    ->relationship('values')
                    ->rules([
                        function () {
                            return function (string $attribute, $value, \Closure $fail) {
                                if (is_array($value) && !empty($value)) {
                                    $hasActiveValue = false;
                                    foreach ($value as $item) {
                                        if (($item['is_active'] ?? true) === true) {
                                            $hasActiveValue = true;
                                            break;
                                        }
                                    }
                                    if (!$hasActiveValue) {
                                        \Filament\Notifications\Notification::make()
                                            ->title('Błąd walidacji')
                                            ->body('Przynajmniej jeden wariant elementu kolekcji musi być aktywny. Nie można zapisać elementu z samymi nieaktywnymi wariantami.')
                                            ->danger()
                                            ->duration(10000)
                                            ->send();
                                        
                                        $fail('Przynajmniej jeden wariant musi być aktywny.');
                                    }
                                }
                            };
                        },
                    ])
                    ->schema([
                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\Hidden::make('name'),
                            Forms\Components\Hidden::make('value'),

                            Forms\Components\Toggle::make('is_active')
                                ->label(__('Aktywny'))
                                ->default(true)
                                ->columnSpanFull(),

                            Forms\Components\TextInput::make('label')
                                ->label('Etykieta')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $old, ?string $state) {
                                    if (
                                        blank($get('name')) || $get('name') === Str::slug($old, '_')
                                    ) {
                                        $set('name', Str::slug($state, '_'));
                                    }

                                    if (
                                        blank($get('value')) || $get('value') === Str::slug($old, '_')
                                    ) {
                                        $set('value', Str::slug($state, '_'));
                                    }
                                }),

                            Forms\Components\TextInput::make('sort_order')
                                ->label('Kolejność')
                                ->numeric()
                                ->default(1),

                            Forms\Components\SpatieMediaLibraryFileUpload::make('collection_item_value')
                                ->label(__('Grafika elementu'))
                                ->collection('collection_item_value')
                                ->extraAttributes(['class' => 'custom-upload-preview'])
                                ->columnSpanFull(),
                        ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('collection_item')
                    ->collection('collection_item')
                    ->label(__('Grafika')),

                Tables\Columns\TextColumn::make('label'),

                Tables\Columns\TextColumn::make('values_count')
                    ->label(__('Ilość'))
                    ->counts('values'),
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
            ])
            ->defaultSort('sort_order');
    }
}

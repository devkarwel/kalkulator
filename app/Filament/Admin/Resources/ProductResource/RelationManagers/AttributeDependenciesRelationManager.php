<?php

namespace App\Filament\Admin\Resources\ProductResource\RelationManagers;

use App\Models\AttributeValue;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AttributeDependenciesRelationManager extends RelationManager
{
    protected static string $relationship = 'attributeDependencies';
    protected static ?string $title = 'Zależności atrybutów';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2)->schema([
                    Forms\Components\Select::make('depends_on_attribute_id')
                        ->label(__('Jeśli wybrano atrybut'))
                        ->options(function () {
                            /** @var Product $record */
                            $record = $this->getOwnerRecord();

                            return $record->attributes()->pluck('label', 'id');
                        })
                        ->reactive()
                        ->required(),

                    Forms\Components\Select::make('depends_on_value_id')
                        ->label(__('i wartość'))
                        ->options(
                            fn (Forms\Get $get) =>
                                AttributeValue::where('attribute_id', $get('depends_on_attribute_id'))
                                    ->pluck('label', 'id')
                        )
                        ->required(),

                    Forms\Components\Select::make('attribute_id')
                        ->label(__('To pokaż atrybut'))
                        ->options(function () {
                            /** @var Product $record */
                            $record = $this->getOwnerRecord();

                            return $record->attributes()->pluck('label', 'id');
                        })
                        ->reactive()
                        ->required(),

                    Forms\Components\Select::make('attribute_value_id')
                        ->label(__('i wartość'))
                        ->options(
                            fn (Forms\Get $get) =>
                                AttributeValue::where('attribute_id', $get('attribute_id'))
                                    ->pluck('label', 'id')
                        )
                        ->nullable()
                        ->helperText(__('Pozostaw puste, aby zależność dotyczyła całego atrybutu.'))
                        ->rules([
                            fn (Forms\Get $get) => function ($attribute, $value, $fail) use ($get) {
                                if (
                                    $get('attribute_id') === $get('depends_on_attribute_id') &&
                                    $value === $get('depends_on_value_id')
                                ) {
                                    $fail(__('Nie można tworzyć zależności od tej samej wartości.'));
                                }

                                if (
                                    $get('attribute_id') === $get('depends_on_attribute_id')
                                ) {
                                    $fail(__('Nie można tworzyć zależności w obrębie tego samego atrybutu.'));
                                }
                            },
                        ]),
                ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('dependencies')
            ->columns([
                Tables\Columns\TextColumn::make('dependsOnAttribute.label')
                    ->label('Atrybut'),
                Tables\Columns\TextColumn::make('dependsOnValue.label')
                    ->label('Wartość'),
                Tables\Columns\TextColumn::make('attribute.label')
                    ->label('Wyświetl'),
                Tables\Columns\TextColumn::make('value.label')
                    ->label('Wyświetl wartość'),
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

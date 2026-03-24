<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\AttributeValueResource\RelationManagers;
use App\Models\AttributeValue;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AttributeValueResource extends Resource
{
    protected static ?string $model = AttributeValue::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationLabel = 'Wartości atrybutów';
    protected static ?string $modelLabel = 'Wartość atrybutu';
    protected static ?string $pluralModelLabel = 'Wartości atrybutów';
    protected static ?int $navigationSort = 2;
    protected static bool $shouldRegisterNavigation = false; // Ukryjemy z nawigacji, dostęp tylko przez RelationManager

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('label')
                    ->label('Nazwa')
                    ->disabled()
                    ->dehydrated(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('attribute.label')
                    ->label('Atrybut'),
                Tables\Columns\TextColumn::make('label')
                    ->label('Nazwa'),
                Tables\Columns\TextColumn::make('priceModifiers_count')
                    ->label('Dopłaty')
                    ->counts('priceModifiers')
                    ->badge()
                    ->color(fn (int $state): string => $state > 0 ? 'success' : 'gray')
                    ->default(0),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('attribute_id')
                    ->label('Atrybut')
                    ->relationship('attribute', 'label')
                    ->preload(),
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
            RelationManagers\PriceModifiersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => \App\Filament\Admin\Resources\AttributeValueResource\Pages\ListAttributeValues::route('/'),
            'create' => \App\Filament\Admin\Resources\AttributeValueResource\Pages\CreateAttributeValue::route('/create'),
            'edit' => \App\Filament\Admin\Resources\AttributeValueResource\Pages\EditAttributeValue::route('/{record}/edit'),
        ];
    }
}


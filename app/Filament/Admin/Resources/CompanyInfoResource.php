<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CompanyInfoResource\Pages;
use App\Models\CompanyInfo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompanyInfoResource extends Resource
{
    protected static ?string $model = CompanyInfo::class;
    protected static ?string $navigationIcon = 'heroicon-s-wrench-screwdriver';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nazwa firmy')
                            ->placeholder(__('podaj nazwę'))
                            ->required(),

                        Forms\Components\TextInput::make('tax_id')
                            ->label('NIP')
                            ->placeholder('numer NIP')
                            ->required(),

                        Forms\Components\Textarea::make('address')
                            ->label('Adres')
                            ->placeholder(__('adres firmy'))
                            ->required()
                            ->rows(3),

                        Forms\Components\TextInput::make('phone')
                            ->label('Telefon')
                            ->placeholder('numer telefonu')
                            ->nullable(),

                        Forms\Components\TextInput::make('phone_alt')
                            ->label('Telefon dodatkowy')
                            ->placeholder('numer telefonu')
                            ->nullable(),

                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->placeholder('adres email')
                            ->email()
                            ->required(),

                        Forms\Components\TextInput::make('bank_account')
                            ->label('Numer konta')
                            ->placeholder('numer konta')
                            ->nullable(),
                    ]),

                    Forms\Components\SpatieMediaLibraryFileUpload::make('logo')
                        ->label('Logo')
                        ->image()
                        ->collection('logo')
                        ->extraAttributes(['class' => 'custom-upload-preview']),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\SpatieMediaLibraryImageColumn::make('logo')
                    ->collection('logo')
                    ->label(__('Logo')),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nazwa')
                    ->limit(25),

                Tables\Columns\TextColumn::make('email')->label('Email'),

                Tables\Columns\TextColumn::make('phone')->label('Telefon'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanyInfos::route('/'),
            'edit' => Pages\EditCompanyInfo::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return self::getModel()::count() === 0;
    }

    public static function canDelete($record): bool
    {
        return false;
    }

    public static function getModelLabel(): string
    {
        return 'Ustawienia';
    }

    public static function getPluralModelLabel(): string
    {
        return self::getModelLabel();
    }
}

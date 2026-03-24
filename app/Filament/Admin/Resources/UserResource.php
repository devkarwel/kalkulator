<?php

namespace App\Filament\Admin\Resources;

use App\Enums\UserRole;
use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers\ProductDiscountsRelationManager;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\Grid::make()->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Konto aktywne')
                            ->columnSpanFull()
                            ->default(true),

                        Forms\Components\TextInput::make('name')
                            ->unique(static::$model, 'name', ignoreRecord: true)
                            ->label('ID klienta')
                            ->placeholder('00000')
                            ->required(),

                        Forms\Components\TextInput::make('email')
                            ->label('E-mail')
                            ->placeholder('jan.kowalski@gmail.com')
                            ->required()
                            ->email()
                            ->unique(static::$model, 'email', ignoreRecord: true),

                        Forms\Components\TextInput::make('password')
                            ->label('Hasło')
                            ->placeholder('********')
                            ->password()
                            ->revealable()
                            ->minLength(8)
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context) => $context === 'create'),

                        Forms\Components\TextInput::make('phone')
                            ->label('Telefon')
                            ->placeholder('+48 123 456 789')
                            ->tel()
                            ->required(),

                        Forms\Components\Select::make('role')
                            ->label('Typ konta')
                            ->options(UserRole::class)
                            ->default(UserRole::USER)
                            ->required(),

                        Forms\Components\TextInput::make('company')
                            ->label('Firma')
                            ->placeholder('nazwa firmy użytkownika'),

                        Forms\Components\Textarea::make('address')
                            ->label('Adres')
                            ->placeholder('adres')
                            ->columnSpanFull(),
                    ]),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('ID Klienta')
                    ->searchable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->icon(fn (bool $state): string => 'heroicon-o-check-circle')
                    ->alignCenter()
                    ->label('Konto aktywne'),

                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (UserRole $state): string => match ($state) {
                        UserRole::ADMIN => 'danger',
                        UserRole::USER => 'info',
                    })
                    ->label('Typ konta'),

                Tables\Columns\TextColumn::make('created_at')
                    ->sortable()
                    ->since()
                    ->dateTimeTooltip()
                    ->label('Utworzono'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('active')
                    ->label('Konta aktywne')
                    ->options([
                        'yes' => 'Tak',
                        'no' => 'Nie',
                    ])
                    ->query(
                        fn (Builder $query, $state): Builder => match ($state['value']) {
                            'yes' => $query->where('is_active', '=', true),
                            'no' => $query->where('is_active', '=', false),
                            default => $query,
                        }
                    ),

                Tables\Filters\SelectFilter::make('role')
                    ->label('Typ konta')
                    ->options([
                        'admin' => UserRole::ADMIN->getLabel(),
                        'user' => UserRole::USER->getLabel(),
                    ])
                    ->query(
                        fn (Builder $query, $state): Builder => match ($state['value']) {
                            'admin' => $query->where('role', UserRole::ADMIN),
                            'user' => $query->where('role', UserRole::USER),
                            default => $query,
                        }
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Tables\Actions\ViewAction::make()
                    ->label('Podgląd')
                    ->color('info'),

                Tables\Actions\DeleteAction::make()
                    ->label('')
                    ->visible(fn ($record) => Auth::id() !== $record->id)
                    ->before(function ($record) {
                        if (Auth::id() === $record->id) {
                            throw new \RuntimeException('Nie możesz sam skasować swojego konta');
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            if ($records->contains('id', Auth::id())) {
                                throw new \RuntimeException('Nie możesz sam skasować swojego konta');
                            }
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ProductDiscountsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Użytkownik';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Użytkownicy';
    }
}

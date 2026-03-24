<?php

namespace App\Filament\Admin\Resources\PriceRangeResource\Pages;

use App\Filament\Admin\Resources\PriceRangeResource;
use App\Models\PriceRange;
use App\Models\PriceRangeStep;
use Filament\Actions;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditPriceRange extends EditRecord
{
    protected static string $resource = PriceRangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('modifyPrices')
                ->label('Aktualizuj ceny')
                ->icon('heroicon-m-shield-exclamation')
                ->form([
                    Grid::make(2)
                        ->schema([
                            Select::make('mode')
                                ->label('Operacja')
                                ->options([
                                    'increase' => 'zwiększ',
                                    'decrease' => 'zmniejsz',
                                ])
                                ->default('increase')
                                ->required(),

                            TextInput::make('value')
                                ->label('Wartość')
                                ->numeric()
                                ->minValue(0)
                                ->maxValue(100)
                                ->required()
                                ->suffix('%'),
                        ]),
                ])
                ->action(function (array $data) {
                    /** @var PriceRange $record */
                    $record = $this->record;

                    foreach ($record->steps as $step) {
                        /** @var PriceRangeStep $step */

                        $currentPrice = $step->price;
                        $modifierValue = $data['value'] / 100;

                        $step->price = $data['mode'] === 'increase' ?
                            round($currentPrice * (1 + $modifierValue), 2) :
                            round($currentPrice * (1 - $modifierValue), 2);

                        $step->save();
                    }

                    Notification::make()
                        ->title('Sukces!')
                        ->body("Wszystkie ceny w aktualnym cenniku zostały zaktualizowane.")
                        ->success()
                        ->send();

                    redirect(
                        route('filament.admin.resources.price-ranges.edit', $this->record)
                    );
                }),
        ];
    }
}

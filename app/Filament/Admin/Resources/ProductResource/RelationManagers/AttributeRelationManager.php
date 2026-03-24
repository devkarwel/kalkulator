<?php

namespace App\Filament\Admin\Resources\ProductResource\RelationManagers;

use App\Enums\AttributeInputType;
use App\Enums\AttributeInputVariant;
use App\Enums\AttributeSideColumn;
use App\Enums\PriceActionModifier;
use App\Enums\PriceTypeModifier;
use App\Enums\Unit;
use App\Models\AttributeValue;
use App\Models\AttributeValuePriceModifier;
use App\Models\Product;
use App\Models\ProductCollection;
use Filament\Forms;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class AttributeRelationManager extends RelationManager
{
    protected static string $relationship = 'attributes';
    protected static ?string $title = 'Atrybuty produktu';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(3)
                    ->schema([

                        Forms\Components\Hidden::make('name'),

                        Forms\Components\Toggle::make('is_active')
                            ->label(__('Atrybut aktywny'))
                            ->default(true)
                            ->columnSpanFull()
                            ->helperText('Jeśli wyłączysz, atrybut będzie całkowicie ukryty. UWAGA: Przynajmniej jedna wartość atrybutu musi być aktywna.'),

                        Forms\Components\Toggle::make('required')
                            ->label(__('Pole wymagane?'))
                            ->default(false)
                            ->columnSpanFull()
                            ->visible(function (Forms\Get $get) {
                                $inputType = $get('input_type') instanceof AttributeInputType ?
                                    $get('input_type') :
                                    AttributeInputType::tryFrom($get('input_type'));

                                return $inputType !== AttributeInputType::FIELD_INPUT;
                            }),

                        Forms\Components\TextInput::make('label')
                            ->label(__('Nagłowek sekcji'))
                            ->live(onBlur: true)
                            ->required()
                            ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $old, ?string $state) {
                                if (
                                    blank($get('name')) || $get('name') === Str::slug($old, '_')
                                ) {
                                    $set('name', Str::slug($state, '_'));
                                }
                            }),

                        Forms\Components\Select::make('input_type')
                            ->label('Typ pola')
                            ->options(AttributeInputType::class)
                            ->default(AttributeInputType::SELECT_INPUT)
                            ->live()
                            ->reactive()
                            ->required(),

                        Forms\Components\Select::make('input_variant')
                            ->label('Wariant')
                            ->options(
                                fn (Forms\Get $get) =>
                                    AttributeInputVariant::optionsForInputType(
                                        $get('input_type') instanceof AttributeInputType ?
                                            $get('input_type') :
                                            AttributeInputType::tryFrom($get('input_type'))
                                    )
                            )
                            ->default(AttributeInputVariant::SELECT_IMAGE_ICON)
                            ->live()
                            ->required()
                            ->reactive(),

                        Forms\Components\Grid::make(3)->schema([
                            Forms\Components\Select::make('column_side')
                                ->label(__('Strona układu'))
                                ->options(AttributeSideColumn::class)
                                ->default(AttributeSideColumn::COLUMN_LEFT),

                            Forms\Components\TextInput::make('nr_step')
                                ->label(__('Krok'))
                                ->numeric()
                                ->minValue(1)
                                ->maxValue(99)
                                ->default(1)
                                ->step(1),

                            Forms\Components\TextInput::make('sort_order')
                                ->label(__('Kolejność'))
                                ->hint('pozycja na kolumnie')
                                ->numeric()
                                ->minValue(1)
                                ->maxValue(99)
                                ->default(1)
                                ->step(1),
                        ]),

                        Forms\Components\Repeater::make('values')
                            ->label('Konfiguracja atrybutu')
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
                                                    ->body('Przynajmniej jedna wartość atrybutu musi być aktywna. Nie można zapisać atrybutu z samymi nieaktywnymi wartościami.')
                                                    ->danger()
                                                    ->duration(10000)
                                                    ->send();
                                                
                                                $fail('Przynajmniej jedna wartość atrybutu musi być aktywna.');
                                            }
                                        }
                                    };
                                },
                            ])
                            ->schema(function (Forms\Get $get) {
                                // Używamy ../../ aby wyjść z zakresu item→repeater→form
                                $rawInputType    = $get('../../input_type');
                                $rawInputVariant = $get('../../input_variant');

                                $inputType = $rawInputType instanceof AttributeInputType
                                    ? $rawInputType
                                    : AttributeInputType::tryFrom((string) $rawInputType);

                                $inputVariant = $rawInputVariant instanceof AttributeInputVariant
                                    ? $rawInputVariant
                                    : AttributeInputVariant::tryFrom((string) $rawInputVariant);

                                $fields = [
                                    Forms\Components\Grid::make()
                                        ->schema([
                                            Forms\Components\Hidden::make('name'),
                                            Forms\Components\Hidden::make('value'),

                                            Forms\Components\Toggle::make('is_active')
                                                ->label(__('Aktywny'))
                                                ->default(true)
                                                ->columnSpanFull(),

                                            Forms\Components\TextInput::make('label')
                                                ->label(__('Nazwa identyfikująca pole'))
                                                ->hintIcon('heroicon-c-question-mark-circle', 'Niewidoczne w przypadku pól tekstowych')
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
                                                ->label(__('Kolejność'))
                                                ->hint('pozycja w grupie')
                                                ->numeric()
                                                ->minValue(1)
                                                ->maxValue(99)
                                                ->default(1)
                                                ->step(1)
                                                ->visible(fn (Forms\Get $get) => $inputType !== AttributeInputType::COLLECTION),

                                            Forms\Components\Toggle::make('config.has_extra_config')
                                                ->label(__('Dodaj tooltip'))
                                                ->columnSpanFull()
                                                ->visible(fn (Forms\Get $get) => $inputType === AttributeInputType::SELECT_INPUT)
                                                ->live(),

                                            Forms\Components\TextInput::make('config.tooltip')
                                                ->label(__('Tooltip na grafice'))
                                                ->columnSpanFull()
                                                ->visible(fn (Forms\Get $get) => $get('config.has_extra_config')),
                                        ]),

                                    Forms\Components\Select::make('collection_id')
                                        ->label('Powiązana kolekcja')
                                        ->options(function () {
                                            /** @var Product $record */
                                            $record = $this->getOwnerRecord();

                                            return ProductCollection::query()
                                                ->where('product_id', $record->id)
                                                ->orderBy('label')
                                                ->pluck('label', 'id');
                                        })
                                        ->nullable()
                                        ->helperText('Jeśli ustawione, kolekcja pojawi się na tym kroku.')
                                        ->visible(fn (Forms\Get $get) => $inputType === AttributeInputType::COLLECTION),
                                ];

                                $fields[] = Forms\Components\SpatieMediaLibraryFileUpload::make('attribute')
                                    ->label(__('Grafika'))
                                    ->collection('attribute')
                                    ->extraAttributes(['class' => 'custom-upload-preview'])
                                    ->columnSpanFull()
                                    ->visible(fn (Forms\Get $get) => (
                                        $inputType === AttributeInputType::ONLY_IMAGE ||
                                        (
                                            $inputType === AttributeInputType::SELECT_INPUT &&
                                            $inputVariant !== AttributeInputVariant::SELECT_TEXT
                                        )
                                    ));

                                $fields[] = Forms\Components\Fieldset::make('Konfiguracja pola input')
                                    ->schema([
                                        Forms\Components\Grid::make(2)
                                            ->schema([
                                                Forms\Components\Hidden::make('config.name'),

                                                Forms\Components\Toggle::make('config.required')
                                                    ->label(__('Pole obowiązkowe'))
                                                    ->default(false),

                                                Forms\Components\Toggle::make('config.hidden_label')
                                                    ->label(__('Ukryj etykietę pola'))
                                                    ->default(false)
                                                    ->reactive(),

                                                Forms\Components\TextInput::make('config.label')
                                                    ->label(__('Etykieta'))
                                                    ->live(onBlur: true)
                                                    ->afterStateUpdated(function (Forms\Get $get, Forms\Set $set, ?string $old, ?string $state) {
                                                        if (
                                                            blank($get('config.name')) || $get('config.name') === Str::slug($old, '_')
                                                        ) {
                                                            $set('config.name', Str::slug($state, '_'));
                                                        }
                                                    })
                                                    ->required(),

                                                Forms\Components\TextInput::make('config.placeholder')
                                                    ->label(__('Placeholder'))
                                                    ->default('-'),

                                                Forms\Components\TextInput::make('config.default_value')
                                                    ->label(__('Wartość domyślna'))
                                                    ->default(null),

                                                Forms\Components\TextInput::make('config.tooltip')
                                                    ->label(__('Tekst wyjaśniający'))
                                                    ->default(null)
                                                    ->visible(fn (Forms\Get $get) => $get('config.hidden_label') !== true),

                                                Forms\Components\Select::make('config.unit')
                                                    ->label('Jednostka miary')
                                                    ->options(Unit::class)
                                                    ->visible(fn (Forms\Get $get) => $inputVariant === AttributeInputVariant::INPUT_NUMBER),

                                                Forms\Components\TextInput::make('config.min_value')
                                                    ->label('Minimalna wartość')
                                                    ->default(null)
                                                    ->visible(fn (Forms\Get $get) => $inputVariant === AttributeInputVariant::INPUT_NUMBER),

                                                Forms\Components\TextInput::make('config.max_value')
                                                    ->label('Maksymalna wartość')
                                                    ->default(null)
                                                    ->visible(fn (Forms\Get $get) => $inputVariant === AttributeInputVariant::INPUT_NUMBER),

                                                Forms\Components\TextInput::make('config.step')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->label('Wartość przedziału')
                                                    ->default(null)
                                                    ->visible(fn (Forms\Get $get) => $inputVariant === AttributeInputVariant::INPUT_NUMBER),

                                                Forms\Components\Select::make('config.input_mode')
                                                    ->label('Tryb wprowadzania')
                                                    ->options([
                                                        'decimal' => 'Liczba zmiennoprzecinkowa',
                                                        'numeric' => 'Liczba całkowita',
                                                    ])
                                                    ->default('decimal')
                                                    ->visible(fn (Forms\Get $get) => $inputVariant === AttributeInputVariant::INPUT_NUMBER),
                                        ]),
                                    ])
                                    ->columns(2)
                                    ->visible(fn (Forms\Get $get) => $inputType === AttributeInputType::FIELD_INPUT);

                                $fields[] = Forms\Components\RichEditor::make('config.description')
                                    ->label(__('Treść komuniaktu'))
                                    ->required()
                                    ->columnSpanFull()
                                    ->visible(fn (Forms\Get $get) => $inputType === AttributeInputType::ONLY_TEXT);

                                return $fields;
                            })
                            ->itemLabel(fn ($state) => $state['label'])
                            ->addActionLabel(__('Dodaj +'))
                            ->reorderable()
                            ->reorderableWithButtons()
                            ->reorderableWithDragAndDrop(false)
                            ->orderColumn('sort_order')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('nr_step')
                    ->label(__('Krok')),

                Tables\Columns\TextColumn::make('label')
                    ->label('Nazwa'),

                Tables\Columns\TextColumn::make('values_count')
                    ->label('Ilość wartości')
                    ->alignCenter()
                    ->counts('values')
                    ->badge()
                    ->color(fn (int $state): string => $state > 0 ? 'success' : 'warning'),

                Tables\Columns\TextColumn::make('dependencies_count')
                    ->label('Ilość zależności')
                    ->alignCenter()
                    ->counts('dependencies')
                    ->badge()
                    ->color(fn (int $state): string => $state > 0 ? 'warning' : 'success'),


                Tables\Columns\TextColumn::make('input_type')
                    ->label('Typ pola'),

                Tables\Columns\TextColumn::make('input_variant')
                    ->label('Wariant'),

                Tables\Columns\TextColumn::make('price_modifiers_count')
                    ->label('Dopłaty')
                    ->alignCenter()
                    ->badge()
                    ->counts('priceModifiers')
                    ->color(fn (int $state): string => $state > 0 ? 'info' : 'gray')
                    ->formatStateUsing(fn (int $state): string => $state > 0 ? "{$state}" : '-'),

            ])
            ->modifyQueryUsing(function ($query) {
                return $query->withCount('priceModifiers');
            })
            ->defaultSort('nr_step')
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('add_price_modifier')
                    ->label('Dopłata')
                    ->icon('heroicon-o-currency-dollar')
                    ->modalHeading('Zarządzanie dopłatami')
                    ->modalWidth('6xl')
                    ->modalSubmitActionLabel('Zapisz zmiany')
                    ->form(function ($record) {
                        /** @var Product $product */
                        $product = $this->getOwnerRecord();
                        
                        return [
                            // === SEKCJA: NOWA DOPŁATA ===
                            Forms\Components\Section::make('Nowa dopłata')
                                ->description('Dodaj nową dopłatę dla wybranej wartości atrybutu')
                                ->schema([
                                    Forms\Components\Grid::make(5)->schema([
                                        Forms\Components\Select::make('new_attribute_value_id')
                                            ->label('Wartość atrybutu')
                                            ->options(fn () => $record->values()->orderBy('sort_order')->pluck('label', 'id'))
                                            ->searchable()
                                            ->placeholder('Wybierz...')
                                            ->required(fn (Forms\Get $get) => !empty($get('new_value'))),
                                        Forms\Components\Select::make('new_action')
                                            ->label('Typ')
                                            ->options(PriceActionModifier::class)
                                            ->default(PriceActionModifier::ADD->value)
                                            ->reactive(),
                                        Forms\Components\Select::make('new_type')
                                            ->label('Rodzaj')
                                            ->options(PriceTypeModifier::class)
                                            ->default(PriceTypeModifier::AMOUNT->value)
                                            ->reactive(),
                                        Forms\Components\TextInput::make('new_value')
                                            ->label('Wartość')
                                            ->numeric()
                                            ->minValue(0)
                                            ->required(fn (Forms\Get $get) => !empty($get('new_attribute_value_id')))
                                            ->prefix(fn (Forms\Get $get) => $get('new_action') === PriceActionModifier::ADD->value ? '+' : '-')
                                            ->suffix(fn (Forms\Get $get) => $get('new_type') === PriceTypeModifier::PERCENT->value ? '%' : ' zł'),
                                        Forms\Components\Toggle::make('new_multiply_by_quantity')
                                            ->label('Za sztukę')
                                            ->inline(false)
                                            ->reactive(),
                                    ]),
                                    
                                    // Warunki wymiarów (tylko gdy "za sztukę")
                                    Forms\Components\Fieldset::make('Warunki wymiarów/ilości')
                                        ->schema([
                                            Forms\Components\Repeater::make('new_dimension_conditions')
                                                ->label('')
                                                ->schema([
                                                    Forms\Components\Grid::make(4)->schema([
                                                        Forms\Components\TextInput::make('min_width')
                                                            ->label('Szer. od (cm)')
                                                            ->numeric()
                                                            ->placeholder('0'),
                                                        Forms\Components\TextInput::make('max_width')
                                                            ->label('Szer. do (cm)')
                                                            ->numeric()
                                                            ->placeholder('∞'),
                                                        Forms\Components\TextInput::make('min_quantity')
                                                            ->label('Min. szt.')
                                                            ->numeric()
                                                            ->integer()
                                                            ->placeholder('1'),
                                                        Forms\Components\TextInput::make('max_quantity')
                                                            ->label('Max. szt.')
                                                            ->numeric()
                                                            ->integer()
                                                            ->placeholder('∞'),
                                                    ]),
                                                ])
                                                ->defaultItems(0)
                                                ->addActionLabel('Dodaj warunek wymiarów')
                                                ->collapsible()
                                                ->itemLabel(fn (array $state) => 
                                                    'Szer: ' . ($state['min_width'] ?? '0') . '-' . ($state['max_width'] ?? '∞') . 
                                                    ' cm | Szt: ' . ($state['min_quantity'] ?? '1') . '-' . ($state['max_quantity'] ?? '∞')
                                                ),
                                        ])
                                        ->visible(fn (Forms\Get $get) => $get('new_multiply_by_quantity')),
                                    
                                    // Warunki atrybutów
                                    Forms\Components\Fieldset::make('Warunki atrybutów')
                                        ->schema([
                                            Forms\Components\Repeater::make('new_attribute_conditions')
                                                ->label('')
                                                ->schema([
                                                    Forms\Components\Grid::make(3)->schema([
                                                        Forms\Components\Select::make('attribute_id')
                                                            ->label('Atrybut')
                                                            ->options(fn () => \App\Models\Attribute::where('product_id', $product->id)
                                                                ->where('input_type', '!=', \App\Enums\AttributeInputType::FIELD_INPUT)
                                                                ->pluck('label', 'id'))
                                                            ->reactive()
                                                            ->searchable(),
                                                        Forms\Components\Select::make('operator')
                                                            ->label('Operator')
                                                            ->options([
                                                                '=' => '= (równe)',
                                                                '!=' => '≠ (różne)',
                                                                '*' => '* (dowolne)',
                                                            ])
                                                            ->default('='),
                                                        Forms\Components\Select::make('attribute_value_id')
                                                            ->label('Wartość')
                                                            ->options(function (Forms\Get $get) {
                                                                $attrId = $get('attribute_id');
                                                                if (!$attrId) return [];
                                                                return \App\Models\AttributeValue::where('attribute_id', $attrId)
                                                                    ->pluck('label', 'id')
                                                                    ->prepend('* (wszystkie)', '*');
                                                            })
                                                            ->searchable()
                                                            ->visible(fn (Forms\Get $get) => $get('operator') !== '*'),
                                                    ]),
                                                ])
                                                ->defaultItems(0)
                                                ->addActionLabel('Dodaj warunek atrybutu')
                                                ->collapsible()
                                                ->itemLabel(function (array $state) use ($product) {
                                                    $attr = \App\Models\Attribute::find($state['attribute_id'] ?? null);
                                                    $val = $state['attribute_value_id'] ?? '*';
                                                    if ($val !== '*') {
                                                        $val = \App\Models\AttributeValue::find($val)?->label ?? $val;
                                                    }
                                                    return ($attr->label ?? '?') . ' ' . ($state['operator'] ?? '=') . ' ' . $val;
                                                }),
                                        ]),
                                ])
                                ->collapsible(),
                            
                            // === SEKCJA: ISTNIEJĄCE DOPŁATY ===
                            Forms\Components\Section::make('Istniejące dopłaty')
                                ->description('Edytuj lub usuń istniejące dopłaty')
                                ->schema([
                                    Forms\Components\Repeater::make('existing_modifiers')
                                        ->label('')
                                        ->schema([
                                            Forms\Components\Grid::make(5)->schema([
                                                Forms\Components\Hidden::make('id'),
                                                Forms\Components\Select::make('attribute_value_id')
                                                    ->label('Wartość atrybutu')
                                                    ->options(fn () => $record->values()->orderBy('sort_order')->pluck('label', 'id'))
                                                    ->disabled(),
                                                Forms\Components\Select::make('action')
                                                    ->label('Typ')
                                                    ->options(PriceActionModifier::class)
                                                    ->reactive(),
                                                Forms\Components\Select::make('type')
                                                    ->label('Rodzaj')
                                                    ->options(PriceTypeModifier::class)
                                                    ->reactive(),
                                                Forms\Components\TextInput::make('value')
                                                    ->label('Wartość')
                                                    ->numeric(),
                                                Forms\Components\Toggle::make('multiply_by_quantity')
                                                    ->label('Za szt.')
                                                    ->inline(false)
                                                    ->reactive(),
                                            ]),
                                            Forms\Components\Fieldset::make('Warunki wymiarów')
                                                ->schema([
                                                    Forms\Components\Repeater::make('dimension_conditions')
                                                        ->label('')
                                                        ->schema([
                                                            Forms\Components\Grid::make(4)->schema([
                                                                Forms\Components\Hidden::make('id'),
                                                                Forms\Components\TextInput::make('min_width')->label('Szer. od')->numeric(),
                                                                Forms\Components\TextInput::make('max_width')->label('Szer. do')->numeric(),
                                                                Forms\Components\TextInput::make('min_quantity')->label('Min. szt.')->numeric()->integer(),
                                                                Forms\Components\TextInput::make('max_quantity')->label('Max. szt.')->numeric()->integer(),
                                                            ]),
                                                        ])
                                                        ->defaultItems(0)
                                                        ->addActionLabel('Dodaj')
                                                        ->collapsible()
                                                        ->collapsed(),
                                                ])
                                                ->visible(fn (Forms\Get $get) => $get('multiply_by_quantity'))
                                                ->columns(1),
                                            Forms\Components\Fieldset::make('Warunki atrybutów')
                                                ->schema([
                                                    Forms\Components\Repeater::make('attribute_conditions')
                                                        ->label('')
                                                        ->schema([
                                                            Forms\Components\Grid::make(3)->schema([
                                                                Forms\Components\Hidden::make('id'),
                                                                Forms\Components\Select::make('attribute_id')
                                                                    ->label('Atrybut')
                                                                    ->options(fn () => \App\Models\Attribute::where('product_id', $product->id)
                                                                        ->where('input_type', '!=', \App\Enums\AttributeInputType::FIELD_INPUT)
                                                                        ->pluck('label', 'id'))
                                                                    ->reactive(),
                                                                Forms\Components\Select::make('operator')
                                                                    ->label('Operator')
                                                                    ->options(['=' => '=', '!=' => '≠', '*' => '*'])
                                                                    ->default('='),
                                                                Forms\Components\Select::make('attribute_value_id')
                                                                    ->label('Wartość')
                                                                    ->options(function (Forms\Get $get) {
                                                                        $attrId = $get('attribute_id');
                                                                        if (!$attrId) return [];
                                                                        return \App\Models\AttributeValue::where('attribute_id', $attrId)
                                                                            ->pluck('label', 'id')
                                                                            ->prepend('* (wszystkie)', '*');
                                                                    })
                                                                    ->visible(fn (Forms\Get $get) => $get('operator') !== '*'),
                                                            ]),
                                                        ])
                                                        ->defaultItems(0)
                                                        ->addActionLabel('Dodaj')
                                                        ->collapsible()
                                                        ->collapsed(),
                                                ])
                                                ->columns(1),
                                        ])
                                        ->default(function () use ($record) {
                                            $valueIds = $record->values()->pluck('id');
                                            $modifiers = AttributeValuePriceModifier::query()
                                                ->whereIn('attribute_value_id', $valueIds)
                                                ->with(['attributeValue', 'conditions.attributeValues'])
                                                ->get();
                                            
                                            return $modifiers->map(function ($modifier) {
                                                // Rozdziel warunki na wymiarowe i atrybutowe
                                                $dimConditions = [];
                                                $attrConditions = [];
                                                
                                                foreach ($modifier->conditions as $c) {
                                                    // Warunki wymiarowe (mają min/max width/quantity)
                                                    $hasDimensionCondition = $c->min_width !== null || $c->max_width !== null || 
                                                        $c->min_quantity !== null || $c->max_quantity !== null;
                                                    
                                                    // Warunki atrybutowe (mają attribute_id)
                                                    $hasAttributeCondition = $c->attribute_id !== null;
                                                    
                                                    if ($hasDimensionCondition) {
                                                        $dimConditions[] = [
                                                            'id' => $c->id,
                                                            'min_width' => $c->min_width,
                                                            'max_width' => $c->max_width,
                                                            'min_quantity' => $c->min_quantity,
                                                            'max_quantity' => $c->max_quantity,
                                                        ];
                                                    }
                                                    
                                                    if ($hasAttributeCondition) {
                                                        $operator = $c->operator ?? '=';
                                                        $valueId = null;
                                                        
                                                        // Jeśli operator to "*" - ustaw "*" jako wartość
                                                        if ($operator === '*') {
                                                            $valueId = '*';
                                                        } elseif ($c->attributeValues->isNotEmpty()) {
                                                            // Jeśli mamy konkretne wartości - weź pierwszą
                                                            $valueId = $c->attributeValues->first()->id;
                                                        } else {
                                                            // Jeśli brak wartości ale operator nie jest "*" - ustaw domyślnie "*"
                                                            $operator = '*';
                                                            $valueId = '*';
                                                        }
                                                        
                                                        $attrConditions[] = [
                                                            'id' => $c->id,
                                                            'attribute_id' => $c->attribute_id,
                                                            'operator' => $operator,
                                                            'attribute_value_id' => $valueId,
                                                        ];
                                                    }
                                                }
                                                
                                                return [
                                                    'id' => $modifier->id,
                                                    'attribute_value_id' => $modifier->attribute_value_id,
                                                    'action' => $modifier->action->value,
                                                    'type' => $modifier->type->value,
                                                    'value' => $modifier->value,
                                                    'multiply_by_quantity' => $modifier->multiply_by_quantity,
                                                    'dimension_conditions' => $dimConditions,
                                                    'attribute_conditions' => $attrConditions,
                                                ];
                                            })->toArray();
                                        })
                                        ->itemLabel(fn (array $state): string => 
                                            AttributeValue::find($state['attribute_value_id'] ?? null)?->label ?? 'Dopłata'
                                        )
                                        ->addable(false)
                                        ->reorderable(false)
                                        ->collapsible()
                                        ->collapsed(),
                                ])
                                ->collapsible(),
                        ];
                    })
                    ->action(function (array $data, $record) {
                        /** @var Product $product */
                        $product = $this->getOwnerRecord();
                        $newCount = 0;
                        $updatedCount = 0;
                        
                        // Debug: loguj dane
                        \Log::info('Price modifier data:', $data);
                        
                        // === DODAJ NOWĄ DOPŁATĘ ===
                        if (!empty($data['new_attribute_value_id']) && filled($data['new_value'])) {
                            try {
                            $modifier = AttributeValuePriceModifier::create([
                                'attribute_value_id' => $data['new_attribute_value_id'],
                                'action' => $data['new_action'] ?? PriceActionModifier::ADD->value,
                                'type' => $data['new_type'] ?? PriceTypeModifier::AMOUNT->value,
                                'value' => $data['new_value'],
                                'multiply_by_quantity' => (bool)($data['new_multiply_by_quantity'] ?? false),
                            ]);
                            
                            \Log::info('Created modifier:', ['id' => $modifier->id, 'attribute_value_id' => $modifier->attribute_value_id]);

                            // Warunki wymiarów
                            foreach ($data['new_dimension_conditions'] ?? [] as $cond) {
                                if (!empty($cond['min_width']) || !empty($cond['max_width']) || 
                                    !empty($cond['min_quantity']) || !empty($cond['max_quantity'])) {
                                    \App\Models\AttributeValuePriceModifierCondition::create([
                                        'attribute_value_price_modifier_id' => $modifier->id,
                                        'product_id' => $product->id,
                                        'min_width' => $cond['min_width'] ?? null,
                                        'max_width' => $cond['max_width'] ?? null,
                                        'min_quantity' => $cond['min_quantity'] ?? null,
                                        'max_quantity' => $cond['max_quantity'] ?? null,
                                    ]);
                                }
                            }

                            // Warunki atrybutów
                            foreach ($data['new_attribute_conditions'] ?? [] as $cond) {
                                if (!empty($cond['attribute_id'])) {
                                    $operator = $cond['operator'] ?? '=';
                                    $condition = \App\Models\AttributeValuePriceModifierCondition::create([
                                        'attribute_value_price_modifier_id' => $modifier->id,
                                        'product_id' => $product->id,
                                        'attribute_id' => $cond['attribute_id'],
                                        'operator' => $operator,
                                    ]);
                                    
                                    // Jeśli operator nie jest "*" i mamy wartość
                                    if ($operator !== '*' && !empty($cond['attribute_value_id']) && $cond['attribute_value_id'] !== '*') {
                                        $condition->attributeValues()->attach($cond['attribute_value_id']);
                                    }
                                }
                            }
                            $newCount++;
                            } catch (\Exception $e) {
                                \Filament\Notifications\Notification::make()
                                    ->title('Błąd zapisu')
                                    ->body('Nie udało się zapisać dopłaty: ' . $e->getMessage())
                                    ->danger()
                                    ->send();
                                throw $e;
                            }
                        }

                        // === AKTUALIZUJ/USUŃ ISTNIEJĄCE ===
                        $existingIds = collect($data['existing_modifiers'] ?? [])->pluck('id')->filter()->toArray();
                        $valueIds = $record->values()->pluck('id');
                        
                        // Usuń usunięte dopłaty (tylko jeśli były wcześniej w existing_modifiers)
                        // Jeśli existingIds jest puste, nie usuwamy nic - może to być pierwsze otwarcie modala
                        if (!empty($existingIds)) {
                            AttributeValuePriceModifier::query()
                                ->whereIn('attribute_value_id', $valueIds)
                                ->whereNotIn('id', $existingIds)
                                ->delete();
                        }

                        // Aktualizuj istniejące
                        foreach ($data['existing_modifiers'] ?? [] as $modData) {
                            if (empty($modData['id'])) continue;

                            $modifier = AttributeValuePriceModifier::find($modData['id']);
                            if (!$modifier) continue;

                            $modifier->update([
                                'action' => $modData['action'],
                                'type' => $modData['type'],
                                'value' => $modData['value'],
                                'multiply_by_quantity' => $modData['multiply_by_quantity'] ?? false,
                            ]);

                            // Usuń stare warunki i dodaj nowe
                            $modifier->conditions()->delete();

                            // Warunki wymiarów
                            foreach ($modData['dimension_conditions'] ?? [] as $cond) {
                                if (!empty($cond['min_width']) || !empty($cond['max_width']) || 
                                    !empty($cond['min_quantity']) || !empty($cond['max_quantity'])) {
                                    \App\Models\AttributeValuePriceModifierCondition::create([
                                        'attribute_value_price_modifier_id' => $modifier->id,
                                        'product_id' => $product->id,
                                        'min_width' => $cond['min_width'] ?? null,
                                        'max_width' => $cond['max_width'] ?? null,
                                        'min_quantity' => $cond['min_quantity'] ?? null,
                                        'max_quantity' => $cond['max_quantity'] ?? null,
                                    ]);
                                }
                            }

                            // Warunki atrybutów
                            foreach ($modData['attribute_conditions'] ?? [] as $cond) {
                                if (!empty($cond['attribute_id'])) {
                                    $operator = $cond['operator'] ?? '=';
                                    $condition = \App\Models\AttributeValuePriceModifierCondition::create([
                                        'attribute_value_price_modifier_id' => $modifier->id,
                                        'product_id' => $product->id,
                                        'attribute_id' => $cond['attribute_id'],
                                        'operator' => $operator,
                                    ]);
                                    
                                    if ($operator !== '*' && !empty($cond['attribute_value_id']) && $cond['attribute_value_id'] !== '*') {
                                        $condition->attributeValues()->attach($cond['attribute_value_id']);
                                    }
                                }
                            }
                            $updatedCount++;
                        }

                        $message = [];
                        if ($newCount > 0) $message[] = "Dodano {$newCount} dopłat(y)";
                        if ($updatedCount > 0) $message[] = "Zaktualizowano {$updatedCount} dopłat(y)";

                        if (count($message) > 0) {
                            \Filament\Notifications\Notification::make()
                                ->title('Zapisano zmiany')
                                ->body(implode('. ', $message))
                                ->success()
                                ->send();
                        } else {
                            \Filament\Notifications\Notification::make()
                                ->title('Brak zmian')
                                ->body('Nie wprowadzono żadnych zmian')
                                ->warning()
                                ->send();
                        }
                    })
                    ->after(function () {
                        $this->resetTable();
                    })
                    ->successNotificationTitle('Zapisano zmiany')
                    ->visible(fn ($record) => $record->values()->count() > 0),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

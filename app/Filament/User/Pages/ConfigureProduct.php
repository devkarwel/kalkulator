<?php

namespace App\Filament\User\Pages;

use App\Enums\AttributeInputType;
use App\Enums\AttributeInputVariant;
use App\Enums\AttributeSideColumn;
use App\Forms\Components\CustomSelectItem;
use App\Mail\ConfigurationSummaryMail;
use App\Models\Attribute;
use App\Models\AttributeDependency;
use App\Models\AttributeValue;
use App\Models\AttributeValuePriceModifier;
use App\Models\Calculation;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\ProductCollectionItem;
use App\Models\ProductCollectionItemValue;
use App\Rules\FieldRules\FieldRuleManager;
use App\Rules\MinQuantityForWidthRule;
use App\Services\PdfGenerator;
use App\Services\PriceCalculator;
use Filament\Actions\Action;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

/**
 * @property mixed $form
 */
class ConfigureProduct extends Page implements HasForms
{
    use InteractsWithForms;

    private const float NUMERIC_STEP_DEFAULT = 0.1;

    protected static ?string $title = 'Kalkulator';
    protected static ?string $navigationIcon = 'heroicon-o-calculator';
    protected static bool $shouldRegisterNavigation = false;
    protected static ?string $slug = 'kalkulator/{slug}';
    protected static string $view = 'filament.user.pages.configure-product';
    protected ?FieldRuleManager $fieldRuleManager = null;

    public ?Product $product = null;
    public array $formData = [];
    public ?float $price = null;

    public function mount(string $slug): void
    {
        $this->product = Product::query()
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        self::$title = $this->product->name;

        $this->form->fill([]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make($this->prepareSteps())
                    ->extraAttributes(['class' => 'custom-form-wizard'])
                    ->statePath('formData'),
            ]);
    }

    protected function getActions(): array
    {
        return [
            Action::make('submit'),
            Action::make('preview'),
        ];
    }

    protected function prepareSteps(): array
    {
        $this->initFieldRuleManager();

        $attributes = Attribute::query()
            ->where('product_id', $this->product->id)
            ->where('is_active', true)
            ->with([
                'dependencies',
                'values' => function ($query) {
                    $query->orderBy('sort_order')
                        ->with('dependencies');
                },
            ])
            ->orderBy('nr_step')
            ->orderBy('sort_order')
            ->get();

        $previewAttributes = $attributes;

        $attributes
            ->groupBy('nr_step')
            ->sortKeys()
            ->each(function (Collection $stepAttributes, int $stepNumber) use (&$steps) {
                $leftRight = $stepAttributes->whereIn('column_side', [
                    AttributeSideColumn::COLUMN_LEFT,
                    AttributeSideColumn::COLUMN_RIGHT,
                ]);
                $full = $stepAttributes->where('column_side', AttributeSideColumn::COLUMN_FULL);

                if ($leftRight->isNotEmpty()) {
                    $steps[] = Wizard\Step::make('Krok ' . $stepNumber)
                        ->hiddenLabel()
                        ->schema([
                            Grid::make()
                                ->schema([
                                    Group::make()->schema([
                                        ...$this->buildColumn($leftRight, AttributeSideColumn::COLUMN_LEFT),
                                    ])->extraAttributes(['class' => 'column-left']),
                                    Group::make()->schema([
                                        ...$this->buildColumn($leftRight, AttributeSideColumn::COLUMN_RIGHT),
                                    ])->extraAttributes(['class' => 'column-right']),
                                ])
                                ->columns([
                                    'default' => 1,
                                    'lg' => 2,
                                ])
                                ->extraAttributes([
                                    'class' => 'wrapper-columns-2',
                                ]),
                        ]);
                }

                if ($full->isNotEmpty()) {
                    $steps[] = Wizard\Step::make('Krok ' . $stepNumber)
                        ->hiddenLabel()
                        ->schema([
                            ...$this->buildColumn($stepAttributes, AttributeSideColumn::COLUMN_FULL),
                        ])
                        ->extraAttributes(['class' => 'column-full']);
                }
            });

        $steps[] = Wizard\Step::make('Podsumowanie')
            ->hiddenLabel()
            ->lazy()
            ->schema([
                Section::make()
                    ->schema([
                        Placeholder::make('summary')
                            ->hiddenLabel()
                            ->reactive()
                            ->content(function () use ($previewAttributes) {
                                $summaryData = $this->getSummaryData($previewAttributes);
                                return new HtmlString(view('filament.forms.components.summary-section', $summaryData)->render());
                            }),
                    ])
                    ->extraAttributes(['class' => 'p-0 lg:p-4 rounded-none']),
            ]);

        return $steps;
    }

    private function initFieldRuleManager(): void
    {
        if ($this->fieldRuleManager === null) {
            $this->fieldRuleManager = app(FieldRuleManager::class);
        }
    }

    protected function getSummaryData(Collection $attributes, bool $withProduct = true): array
    {

        $formData = $this->formData;
        $summary = [];
        $priceInfo = [];
        $priceDetails = []; // Szczegóły dopłat

        // Pobierz ilość z formData
        $quantity = $this->getQuantityFromFormData($formData);
        $width = $this->getWidthFromFormData($formData);
        
        // Najpierw zbierz wszystkie dopłaty, które powinny być wyświetlone (TYLKO te które pasują do warunków)
        $allModifiersForDisplay = [];
        foreach ($formData as $key => $value) {
            if (in_array($key, ['only_image', 'only_text', 'summary']) || is_array($value)) {
                continue;
            }
            
            $attribute = $attributes->firstWhere('name', $key);
            if ($attribute && $attribute->input_type === AttributeInputType::SELECT_INPUT) {
                $selected = $attribute->values->firstWhere('id', $value);
                if ($selected) {
                    $modifiers = AttributeValuePriceModifier::query()
                        ->where('attribute_value_id', $selected->id)
                        ->with(['conditions.attributeValues', 'attributeValue'])
                        ->get();
                    
                    foreach ($modifiers as $modifier) {
                        // Sprawdź czy modyfikator pasuje do warunków przed dodaniem
                        $shouldApply = $modifier->shouldApply($formData, $this->product, $width, $quantity);
                        
                        if ($shouldApply) {
                            $allModifiersForDisplay[] = [
                                'modifier' => $modifier,
                                'attribute_label' => $attribute->label,
                                'value_label' => $selected->label,
                            ];
                        }
                    }
                }
            }
        }
        
        // Pobierz informacje o cenie i dopłatach z PriceCalculator
        try {
            $priceInfo = (new PriceCalculator($this->product))->calculate($formData);
            // Użyj dopłat z PriceCalculator
            $priceDetails = $priceInfo['applied_modifiers'] ?? [];
            
            // Dodaj dopłaty, które są wyświetlane w podsumowaniu, ale nie zostały doliczone (z powodu warunków)
            // i dolicz je ręcznie do ceny
            foreach ($allModifiersForDisplay as $modifierData) {
                $modifier = $modifierData['modifier'];
                $isAlreadyApplied = false;
                
                // Sprawdź czy dopłata już jest w priceDetails
                foreach ($priceDetails as $detail) {
                    if (isset($detail['modifier_id']) && $detail['modifier_id'] === $modifier->id) {
                        $isAlreadyApplied = true;
                        break;
                    }
                }
                
                // Jeśli dopłata nie jest doliczona, ale jest wyświetlana, dolicz ją
                if (!$isAlreadyApplied) {
                    $calculatedValue = (float)$modifier->value;
                    if ($modifier->multiply_by_quantity && $quantity > 0) {
                        $calculatedValue = $calculatedValue * $quantity;
                    }
                    
                    // Jeśli to procent, oblicz rzeczywistą wartość dopłaty
                    if ($modifier->type === \App\Enums\PriceTypeModifier::PERCENT) {
                        $basePrice = $priceInfo['price'] ?? 0;
                        $adjustment = $basePrice * ((float)$modifier->value / 100);
                    } else {
                        $adjustment = $modifier->multiply_by_quantity && $quantity > 0 
                            ? (float)$modifier->value * $quantity 
                            : (float)$modifier->value;
                    }
                    
                    // Jeśli to odejmowanie, zmień znak
                    if ($modifier->action === \App\Enums\PriceActionModifier::SUBTRACT) {
                        $adjustment = -$adjustment;
                    }
                    
                    // Dolicz do ceny przed rabatem
                    if (isset($priceInfo['price'])) {
                        $priceInfo['price'] += $adjustment;
                    }
                    
                    // Dolicz do ceny końcowej (po rabacie) - rabat pozostaje bez zmian
                    if (isset($priceInfo['final_price'])) {
                        $priceInfo['final_price'] += $adjustment;
                    }
                    
                    // Dodaj do szczegółów dopłat
                    $priceDetails[] = [
                        'label' => $modifierData['value_label'],
                        'base_value' => (float)$modifier->value,
                        'calculated_value' => abs($adjustment),
                        'action' => $modifier->action->value,
                        'type' => $modifier->type->value,
                        'multiply_by_quantity' => $modifier->multiply_by_quantity,
                        'quantity' => $quantity,
                        'modifier_id' => $modifier->id,
                        'attribute_value_id' => $modifier->attribute_value_id, // Dodajemy dla deduplikacji
                    ];
                }
            }
            
            // Deduplikuj priceDetails - dla każdej wartości atrybutu pokazuj tylko jedną dopłatę
            // (najlepiej tę która została zastosowana przez PriceCalculator)
            $uniquePriceDetails = [];
            $seenAttributeValueIds = [];
            foreach ($priceDetails as $detail) {
                $attributeValueId = $detail['attribute_value_id'] ?? null;
                $modifierId = $detail['modifier_id'] ?? null;
                
                // Jeśli mamy attribute_value_id, deduplikuj po nim
                if ($attributeValueId !== null) {
                    if (!in_array($attributeValueId, $seenAttributeValueIds)) {
                        $seenAttributeValueIds[] = $attributeValueId;
                        $uniquePriceDetails[] = $detail;
                    }
                } elseif ($modifierId !== null) {
                    // Jeśli nie ma attribute_value_id, ale jest modifier_id, deduplikuj po modifier_id
                    $seenModifierIds = array_column($uniquePriceDetails, 'modifier_id');
                    if (!in_array($modifierId, $seenModifierIds)) {
                        $uniquePriceDetails[] = $detail;
                    }
                } else {
                    // Jeśli nie ma ani attribute_value_id ani modifier_id, dodaj (może być stara struktura)
                    // Ale sprawdź czy label nie jest już w liście
                    $existingLabels = array_column($uniquePriceDetails, 'label');
                    if (!in_array($detail['label'] ?? '', $existingLabels)) {
                        $uniquePriceDetails[] = $detail;
                    }
                }
            }
            $priceDetails = $uniquePriceDetails;
            
        } catch (\Throwable $exception) {
            Log::error('ConfigureProduct: getSummaryData error', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);
            // Jeśli kalkulacja się nie powiodła, kontynuuj bez informacji o cenie
        }

        if ($withProduct) {
            $summary[] = [
                'type' => 'product',
                'label' => 'Rodzaj produktu',
                'value' => $this->product->name,
            ];
        }

        foreach ($formData as $key => $value) {
            if (in_array($key, ['only_image', 'only_text', 'summary'])) {
                continue;
            }

            $attribute = null;
            $item = null;
            $variant = null;

            // KOLEKCJA
            if (str_starts_with($key, 'collection_') && str_ends_with($key, '_item_id')) {
                $collectionId = (int) (string) str($key)->after('collection_')->before('_item_id');

                $itemId = $formData["collection_{$collectionId}_item_id"] ?? null;
                $variantId = $formData["collection_{$collectionId}_value_id"] ?? null;

                $item = ProductCollectionItem::find($itemId);
                $variant = ProductCollectionItemValue::find($variantId);

                $summary[] = [
                    'type' => 'collection_type',
                    'label' => 'Kolekcja',
                    'value' => $item?->label,
                    'image' => $item?->getFirstMediaUrl('collection_item'),
                ];

                if ($variant) {
                    $summary[] = [
                        'type' => 'collection_value',
                        'label' => 'Wariant kolekcji',
                        'value' => $variant?->label,
                        'image' => $variant->getFirstMediaUrl('collection_item_value'),
                    ];
                }

                continue;
            }

            // FIELD_INPUT (np. wymiary, ilość)
            if (is_array($value)) {
                $attribute = $attributes->firstWhere('id', (int) $key);

                if (!$attribute || !is_iterable($attribute->values)) {
                    continue;
                }

                $values = collect($attribute->values)
                    ->map(function ($val) use ($value) {
                        return [
                            'label' => $val->label,
                            'value' => $value[$val->id] ?? null,
                            'unit' =>  ($val->config['unit'] ?? ''),
                        ];
                    });

                if ($values->isNotEmpty()) {
                    $summary[] = [
                        'type' => AttributeInputType::FIELD_INPUT->value,
                        'label' => $attribute->label,
                        'value' => $values,
                    ];
                }

                continue;
            }

            // SELECT_INPUT i inne proste wartości
            $attribute = $attributes->firstWhere('name', $key);

            if ($attribute && $attribute->input_type === AttributeInputType::SELECT_INPUT) {
                $selected = $attribute->values->firstWhere('id', $value);

                if ($selected) {
                    // Pobierz dopłaty dla tej wartości atrybutu (tylko do wyświetlenia przy atrybucie)
                    $modifiers = AttributeValuePriceModifier::query()
                        ->where('attribute_value_id', $selected->id)
                        ->with(['conditions.attributeValues'])
                        ->get();

                    $appliedModifiers = [];
                    foreach ($modifiers as $modifier) {
                        $shouldApply = $modifier->shouldApply($formData, $this->product, $width, $quantity);
                        
                        // Wyświetlaj dopłatę TYLKO jeśli warunki są spełnione
                        if ($shouldApply) {
                            // Format dla wyświetlania przy atrybucie: "+20zł / sztukę" lub "+20zł"
                            $displayText = $modifier->getTooltipText();
                            if ($modifier->multiply_by_quantity) {
                                $displayText .= ' / sztukę';
                            }

                            $appliedModifiers[] = [
                                'text' => $displayText,
                                'value' => (float)$modifier->value,
                                'type' => $modifier->type->value,
                                'action' => $modifier->action->value,
                                'multiply_by_quantity' => $modifier->multiply_by_quantity,
                                'modifier_id' => $modifier->id, // ID modyfikatora dla deduplikacji
                            ];
                        }
                    }

                    $summary[] = [
                        'type' => AttributeInputType::SELECT_INPUT->value,
                        'label' => $attribute->label,
                        'value' => $selected->label,
                        'image' => $selected->getFirstMediaUrl('attribute'),
                        'price_modifiers' => $appliedModifiers,
                    ];
                }

                continue;
            }
        }

        // priceInfo i priceDetails są już pobrane wcześniej z PriceCalculator
        // Jeśli nie udało się pobrać wcześniej, spróbuj ponownie
        if (empty($priceInfo)) {
            try {
                $priceInfo = (new PriceCalculator($this->product))->calculate($formData);
                $priceDetails = $priceInfo['applied_modifiers'] ?? [];
            } catch (\Throwable $exception) {
                // Pozostaw puste jeśli nie udało się obliczyć
            }
        }

        return [
            'data' => $summary,
            'price' => $priceInfo,
            'price_details' => $priceDetails,
            'user' => Auth::user(),
        ];
    }

    protected function getQuantityFromFormData(array $formData): int
    {
        if (!$this->product->quantity_attribute) {
            return 1;
        }

        foreach ($formData as $key => $value) {
            if (!is_array($value)) {
                continue;
            }

            foreach ($value as $k => $v) {
                if ($k == $this->product->quantity_attribute) {
                    return (int)$v > 0 ? (int)$v : 1;
                }
            }
        }

        return 1;
    }

    protected function getWidthFromFormData(array $formData): ?float
    {
        if (!$this->product->width_attribute) {
            return null;
        }

        foreach ($formData as $key => $value) {
            if (!is_array($value)) {
                continue;
            }

            foreach ($value as $k => $v) {
                if ($k == $this->product->width_attribute) {
                    return (float)$v;
                }
            }
        }

        return null;
    }

    protected function buildColumn(Collection $attributes, AttributeSideColumn $side): array
    {
        return $attributes
            ->filter(fn (Attribute $attr) => $attr->column_side === $side)
            ->sortBy('sort_order')
            ->map(function (Attribute $attribute) {
                return $this->makeFieldComponent($attribute);
            })
            ->values()
            ->all();
    }

    protected function makeFieldComponent(Attribute $attribute): Component
    {
        return match ($attribute->input_type) {
            AttributeInputType::COLLECTION => $this->makeCollectionFields($attribute),

            AttributeInputType::SELECT_INPUT => $this->makeSelectFields($attribute),

            AttributeInputType::FIELD_INPUT => Group::make($this->makeInputFields($attribute)),

            AttributeInputType::ONLY_IMAGE => Group::make($this->makeOnlyImageFields($attribute)),

            AttributeInputType::ONLY_TEXT => Group::make($this->makeOnlyTextFields($attribute)),

            default => Placeholder::make($attribute->name)
                ->label($attribute->label)
                ->content('Nieobsługiwany typ pola')
                ->reactive(),
        };
    }

    protected function makeCollectionFields(Attribute $attribute): Component
    {
        $attributeValue = $attribute->values()->first();
        $collection = ProductCollection::with(['items', 'items.values'])
            ->where('id', $attributeValue->collection_id)
            ->first();

        return Grid::make(2)
            ->schema([
                Group::make()->schema([
                    CustomSelectItem::make("collection_{$collection->id}_item_id")
                        ->label($attribute->label)
                        ->options(
                            $collection->items->mapWithKeys(fn (ProductCollectionItem $item) => [
                                $item->id => [
                                    'name' => $item->name,
                                    'label' => $item->label,
                                    'value' => $item->value,
                                    'img' => $item->getFirstMediaUrl('collection_item') ?? null,
                                    'is_active' => $item->is_active ?? true,
                                ],
                            ])->toArray()
                        )
                        ->required(function () use ($attribute) {
                            // Pole jest wymagane tylko jeśli atrybut jest wymagany i są aktywne wartości
                            return $attribute->required && $attribute->values->contains(fn (AttributeValue $option) => $option->is_active);
                        })
                        ->variant($attribute->input_variant)
                        ->reactive()
                        ->afterStateUpdated(fn (Set $set) => $set("collection_{$collection->id}_value_id", null)),
                ]),
                Group::make()->schema([
                    CustomSelectItem::make("collection_{$collection->id}_value_id")
                        ->label('Kolory do wyboru')
                        ->options(
                            function (Get $get) use ($collection, $attribute) {
                                $itemId = $get("collection_{$collection->id}_item_id");

                                if (!$itemId) {
                                    return [];
                                }

                                /** @var ProductCollectionItem $item */
                                $item = $collection->items->firstWhere('id', $itemId);
                                if (!$item) {
                                    return [];
                                }

                                return $item->values->mapWithKeys(fn ($value) => [
                                    $value->id => [
                                        'label' => $value->label,
                                        'value' => $value->value,
                                        'img' => $value->getFirstMediaUrl('collection_item_value') ?? null,
                                        'is_active' => $value->is_active ?? true,
                                    ],
                                ])->toArray();
                            }
                        )
                        ->required(function (Get $get) use ($attribute, $collection) {
                            // Pole jest wymagane tylko jeśli atrybut jest wymagany i są dostępne opcje
                            if (!$attribute->required) {
                                return false;
                            }
                            
                            $itemId = $get("collection_{$collection->id}_item_id");
                            if (!$itemId) {
                                return false;
                            }
                            
                            $item = $collection->items->firstWhere('id', $itemId);
                            return $item && $item->values->isNotEmpty();
                        })
                        ->variant($attribute->input_variant)
                        ->reactive(),
                ]),
            ])
            ->extraAttributes([
                'class' => 'wrapper-columns-2',
            ]);
    }

    protected function makeSelectFields(Attribute $attribute): Component
    {
        $field = CustomSelectItem::make($attribute->name)
            ->label($attribute->label)
            ->options(function (Get $get) use ($attribute) {
                $filteredValues = $attribute->values
                    ->filter(fn (AttributeValue $option) => $this->shouldValueBeVisible($option, $get));

                // Warunki numeryczne dla "Strona sterowania" (produkt 25mm i 50mm)
                if ($attribute->name === 'strona_sterowania' && in_array($this->product->id, [3, 4])) {
                    $widthValue = $this->getWidthValue($get);
                    $threshold = $this->product->id === 3 ? 40 : 60; // 25mm: 40cm, 50mm: 60cm
                    
                    if ($widthValue !== null) {
                        $filteredValues = $filteredValues->filter(function (AttributeValue $option) use ($widthValue, $threshold) {
                            $optionSlug = strtolower($option->name);
                            
                            // Szerokość <= threshold: tylko LP i PL
                            if ($widthValue <= $threshold) {
                                return str_starts_with($optionSlug, 'lp_') || str_starts_with($optionSlug, 'pl_');
                            }
                            
                            // Szerokość > threshold: LL, LP, PL, PP (wszystkie)
                            return true;
                        });
                    }
                }

                return $filteredValues
                    ->mapWithKeys(function (AttributeValue $option) {
                        // Pobierz dopłaty dla tej wartości atrybutu
                        $modifiers = AttributeValuePriceModifier::query()
                            ->where('attribute_value_id', $option->id)
                            ->with(['conditions.attributeValues'])
                            ->get();

                        $hasPriceModifier = $modifiers->isNotEmpty();

                        // Połącz istniejący tooltip z tooltipem dopłaty
                        $existingTooltip = $option->config['tooltip'] ?? null;
                        $combinedTooltip = $existingTooltip;
                        if ($hasPriceModifier) {
                            $combinedTooltip = $existingTooltip 
                                ? $existingTooltip . ' | Dopłata wymagana'
                                : 'Dopłata wymagana';
                        }

                        return [
                            $option->id => [
                                'label' => $option->label,
                                'value' => $option->value,
                                'tooltip' => $combinedTooltip,
                                'has_price_modifier' => $hasPriceModifier, // Flaga że ma dopłatę (dla ikony $)
                                'img' => $option->getFirstMediaUrl('attribute') ?? null,
                                'is_active' => $option->is_active,
                            ],
                        ];
                    })->toArray();
            })
            ->required(function (Get $get) use ($attribute) {
                // Pole jest wymagane tylko jeśli atrybut jest wymagany i są widoczne opcje
                if (!$attribute->required) {
                    return false;
                }
                
                $filteredValues = $attribute->values
                    ->filter(fn (AttributeValue $option) => $this->shouldValueBeVisible($option, $get));
                
                return $filteredValues->isNotEmpty();
            })
            ->variant($attribute->input_variant)
            ->reactive();

        $dependentAttributes = AttributeDependency::query()
            ->where('depends_on_attribute_id', $attribute->id)
            ->with('attribute')
            ->get()
            ->pluck('attribute.name')
            ->unique()
            ->toArray();

        if (!empty($dependentAttributes)) {
            $field->afterStateUpdated(function (Set $set) use ($dependentAttributes) {
                foreach ($dependentAttributes as $attrName) {
                    $set($attrName, null);
                }
            });
        }

        return $field;
    }

    protected function makeInputFields(Attribute $attribute): array
    {
        $header = Placeholder::make($attribute->name)
            ->hiddenLabel()
            ->content(new HtmlString("<h3 class='header_label'>{$attribute->label}</h3>"));

        $fields = $attribute->values->map(function ($value) use ($attribute) {
            $idInputName = "{$attribute->id}.{$value->id}";

            $inputField = TextInput::make($idInputName)
                ->label($value->config['label'])
                ->placeholder($value->config['placeholder'])
                ->required($value->config['required'] ?? false)
                ->visible(fn (Get $get) => $this->shouldValueBeVisible($value, $get))
                ->extraAttributes(['class' => 'attribute-item__input'])
                ->live()
                ->debounce(0)
                ->afterStateUpdated(function ($livewire, TextInput $component) {
                    $livewire->validateOnly($component->getStatePath());
                });

            if ($attribute->input_variant === AttributeInputVariant::INPUT_NUMBER) {
                $inputField->numeric();
                $inputField->step(self::NUMERIC_STEP_DEFAULT);
            }

            if (array_key_exists('min_value', $value->config)) {
                $inputField
                    ->minValue($value->config['min_value']);
            }

            if (array_key_exists('max_value', $value->config)) {
                $inputField->maxValue($value->config['max_value']);
            }

            if (array_key_exists('step', $value->config)) {
                $inputField->step($value->config['step']);
            }

            if (array_key_exists('input_mode', $value->config)) {
                if (($value->config['input_mode'] ?? 'decimal') === 'numeric') {
                    $inputField->rules(['integer']);
                }
            }

            if (array_key_exists('tooltip', $value->config) && $value->config['tooltip'] !== null) {
                $inputField
                    ->hintIcon(
                        icon: asset('images/info.svg'),
                        tooltip: $value->config['tooltip'],
                    );
            }

            if (array_key_exists('unit', $value->config)) {
                $inputField->suffix($value->config['unit']);
            }

            if (array_key_exists('hidden_label', $value->config)) {
                if ($value->config['hidden_label'] === true) {
                    $inputField->hiddenLabel(true)
                        ->hintIcon(null);
                } else {
                    $inputField->label($value->config['label']);
                }

            }

            $this->fieldRuleManager->apply($this->product, $this->formData, $value, $inputField);

            // Dodaj walidację wymaganej ilości dla pola ilości
            if ($value->id == $this->product->quantity_attribute) {
                $inputField->rules([
                    fn () => new MinQuantityForWidthRule($this->product, $this->formData),
                ]);
            }

            return $inputField;
        })->all();

        return [$header, ...$fields];
    }

    protected function makeOnlyImageFields(Attribute $attribute): array
    {
        return $attribute->values->map(function ($value) {
            /** @phpstan-ignore-next-line */
            $imgFull = $value->getFirstMediaUrl('attribute');

            $zoomIcon = asset('images/zoom.svg');

            return Placeholder::make('only_image')
                ->hiddenLabel()
                ->content(
                    new HtmlString("
                        <a href='{$imgFull}' target='_blank' class='attribute-item relative'>
                            <img src='{$imgFull}' alt='{$value->label}' class='attribute-item__image'/>
                            <img src='{$zoomIcon}' alt='zoom' class='attribute-item__zoom'/>
                        </a>")
                )
                ->visible(fn (Get $get) => $this->shouldValueBeVisible($value, $get));
        })->all();
    }

    protected function makeOnlyTextFields(Attribute $attribute): array
    {
        return $attribute->values->map(function (AttributeValue $value) use ($attribute) {
            return Placeholder::make('only_text')
                ->hiddenLabel()
                ->content(
                    new HtmlString($value->config['description'])
                )
                ->visible(fn (Get $get) => $this->shouldValueBeVisible($value, $get))
                ->extraAttributes(['class' => 'attribute-item__text']);
        })->all();
    }

    protected function shouldValueBeVisible(AttributeValue $value, Get $get): bool
    {
        if ($value->dependencies->isEmpty()) {
            return true;
        }

        $grouped = $value->dependencies->groupBy('depends_on_attribute_id');

        foreach ($grouped as $attributeId => $deps) {
            $dependsAttrName = $deps->first()->dependsOnAttribute?->name;
            $selected = $get($dependsAttrName);

            $selectedInt = is_numeric($selected) ? (int) $selected : 0;

            $matchesAny = false;
            foreach ($deps as $dependency) {
                $dependsOnValueId = (int) $dependency->depends_on_value_id;

                if ($selectedInt === $dependsOnValueId) {
                    $matchesAny = true;
                    break;
                }
            }

            if (!$matchesAny) {
                return false;
            }
        }

        return true;
    }

    protected function getWidthValue(Get $get): ?float
    {
        if (!$this->product->width_attribute) {
            return null;
        }

        // Znajdź atrybut wymiarów (szerokość)
        $widthAttributeValue = AttributeValue::find($this->product->width_attribute);
        if (!$widthAttributeValue) {
            return null;
        }

        $widthAttribute = $widthAttributeValue->attribute;
        if (!$widthAttribute) {
            return null;
        }

        // Pobierz wartość szerokości z formularza (format: {attribute_id}.{value_id})
        $widthInputName = "{$widthAttribute->id}.{$widthAttributeValue->id}";
        $widthValue = $get($widthInputName);

        if ($widthValue === null || $widthValue === '') {
            return null;
        }

        return (float) $widthValue;
    }

    public function submit(): void
    {
        try {
            $attributes = Attribute::query()
                ->where('product_id', $this->product->id)
                ->where('is_active', true)
                ->with(['values'])
                ->get();
            $summary = $this->getSummaryData($attributes, false);
            $summary['product'] = $this->product->name;
            
            // Użyj zaktualizowanego priceInfo z getSummaryData (zawiera dopłaty)
            $priceInfo = $summary['price'] ?? [];

            $user = Auth::user();
            $userEmail = $user->email;

            $pdfUrl = new PdfGenerator()
                ->generate($summary, $priceInfo);

            $calculation = Calculation::create([
                'user_id' => $user->id,
                'product_id' => $this->product->id,
                'email' => $user->email,
                'pdf_path' => $pdfUrl,
                'summary' => array_merge($summary, $priceInfo),
            ]);

            Mail::to($userEmail)->send(new ConfigurationSummaryMail($pdfUrl, $this->product->name));

            activity()
                ->performedOn($calculation)
                ->causedBy($user)
                ->log('Wycena wysłana na maila');

            Notification::make()
                ->title('Sukces!')
                ->body('Twoja konfiguracja została wysłana na Twój adres e-mail.')
                ->success()
                ->send();

            redirect()->route('filament.user.pages.kalkulator');
        } catch (\Exception $e) {
            Notification::make()
                ->title('Błąd kalkulacji')
                ->body($e->getMessage())
                ->danger()
                ->persistent()
                ->duration(null)
                ->send();
            
            // Przewiń stronę do góry aby notyfikacja była widoczna
            $this->dispatch('scroll-to-top');
        }
    }

    public function preview(): void
    {
        try {
            $attributes = Attribute::query()
                ->where('product_id', $this->product->id)
                ->where('is_active', true)
                ->with(['values'])
                ->get();
            $summary = $this->getSummaryData($attributes, false);
            $summary['product'] = $this->product->name;
            
            // Użyj zaktualizowanego priceInfo z getSummaryData (zawiera dopłaty)
            $priceInfo = $summary['price'] ?? [];

            $user = Auth::user();
            
            $pdfPath = (new PdfGenerator())
                ->generate($summary, $priceInfo);

            $calculation = Calculation::create([
                'user_id' => $user->id,
                'product_id' => $this->product->id,
                'email' => $user->email,
                'pdf_path' => $pdfPath,
                'summary' => array_merge($summary, $priceInfo),
            ]);

            activity()
                ->performedOn($calculation)
                ->causedBy($user)
                ->log('Wycena wyświetlona w zakładce');

            $this->dispatch('open-pdf-preview', [
                'url' => Storage::url($pdfPath),
            ]);
        } catch (\Exception $e) {
            Notification::make()
                ->title('Błąd kalkulacji')
                ->body($e->getMessage())
                ->danger()
                ->persistent()
                ->duration(null)
                ->send();
            
            // Przewiń stronę do góry aby notyfikacja była widoczna
            $this->dispatch('scroll-to-top');
        }
    }

    public function updatedInteractsWithForms(string $statePath): void
    {
        $this->dispatch('formDataUpdated', $this->formData);
    }

    public function updated($property)
    {
        $this->validateOnly($property);

        if (!str_starts_with($property, 'formData.')) {
            return;
        }

        $key = Str::after($property, 'formData.');

        $this->resetDependentFields($key);
        
        // Wyślij zaktualizowane dane formularza do SummaryBox (np. po zmianie ilości)
        $this->dispatch('formDataUpdated', $this->formData);
    }

    private function resetDependentFields(string $key): void
    {
        $attribute = null;

        // Obsługa kolekcji
        if (\Illuminate\Support\Str::startsWith($key, 'collection_') && \Illuminate\Support\Str::endsWith($key, '_item_id')) {
            $collectionId = (int) \Illuminate\Support\Str::between($key, 'collection_', '_item_id');
            $this->formData["collection_{$collectionId}_value_id"] = null;

            $attribute = Attribute::whereHas('values', function ($query) use ($collectionId) {
                $query->where('collection_id', $collectionId);
            })->first();
        } else {
            $attribute = Attribute::where('name', $key)->first();
        }

        if (!$attribute) {
            return;
        }

        // Pobierz wszystkie zależności, które są uzależnione od tego atrybutu
        $dependencies = \App\Models\AttributeDependency::where('depends_on_attribute_id', $attribute->id)->get();

        foreach ($dependencies as $dependency) {
            $dependentAttribute = $dependency->attribute;
            if (!$dependentAttribute) {
                continue;
            }

            // Wyczyść wartość zależnego atrybutu w formData (po nazwie)
            if (isset($this->formData[$dependentAttribute->name])) {
                unset($this->formData[$dependentAttribute->name]);
            }
            // Wyczyść wartość zależnego atrybutu w formData (po id, np. tablica wymiarów)
            if (isset($this->formData[$dependentAttribute->id]) && is_array($this->formData[$dependentAttribute->id])) {
                $this->formData[$dependentAttribute->id] = [];
            }

            // Obsługa kolekcji zależnych (jeśli atrybut jest kolekcją)
            if ($dependentAttribute->input_type === \App\Enums\AttributeInputType::COLLECTION) {
                $attributeValue = $dependentAttribute->values()->first();
                if ($attributeValue) {
                    $collectionId = $attributeValue->collection_id;
                    $this->formData["collection_{$collectionId}_item_id"] = null;
                    $this->formData["collection_{$collectionId}_value_id"] = null;
                }
            }

            // Rekurencyjnie wyczyść kolejne zależności
            $this->resetDependentFields($dependentAttribute->name);
        }
    }
}

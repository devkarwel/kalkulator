<?php

namespace App\Livewire;

use App\Enums\AttributeInputType;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\AttributeValuePriceModifier;
use App\Models\Product;
use App\Models\ProductCollectionItem;
use App\Services\PriceCalculator;
use Livewire\Component;

class SummaryBox extends Component
{
    public Product $product;
    public array $formData = [];
    public array $summaryData = [];
    public array $priceInfo = [];
    public array $priceDetails = [];

    public bool $visible = false;

    protected $listeners = ['formDataUpdated' => 'updateData'];

    public function mount()
    {
        $this->summaryData = $this->getSummaryData();
        $this->updatePriceInfo();
    }

    public function toggleVisibility(): void
    {
        $this->visible = ! $this->visible;
    }

    public function updateData(array $data): void
    {
        $this->formData = $data;
        $this->summaryData = $this->getSummaryData();
        $this->updatePriceInfo();
    }

    protected function updatePriceInfo(): void
    {
        $this->priceInfo = [];
        $this->priceDetails = [];

        if (empty($this->formData)) {
            return;
        }

        // Nie pokazuj ceny jeśli wymiary nie zostały jeszcze wprowadzone
        $width = $this->getWidthFromFormData($this->formData);
        $height = $this->getHeightFromFormData($this->formData);
        
        if ($width === null || $width <= 0 || $height === null || $height <= 0) {
            return;
        }

        try {
            $calculator = new PriceCalculator($this->product);
            $this->priceInfo = $calculator->calculate($this->formData);
            $this->priceDetails = $this->priceInfo['applied_modifiers'] ?? [];
        } catch (\Throwable $exception) {
            // Jeśli kalkulacja się nie powiodła, pozostaw puste
        }
    }

    public function getSummaryData(): array
    {
        $attributes = Attribute::with('values')->where('product_id', $this->product->id)->get();
        $summary = [];

        // Pobierz ilość i szerokość dla dopłat
        $quantity = $this->getQuantityFromFormData($this->formData);
        $width = $this->getWidthFromFormData($this->formData);

        foreach ($this->formData as $key => $value) {
            if (in_array($key, ['ilosc', 'wymiary'])) {
                continue;
            }

            $attribute = $attributes->firstWhere('name', $key);
            
            if ($attribute && in_array($attribute->input_type, [
                AttributeInputType::ONLY_IMAGE,
                AttributeInputType::ONLY_TEXT,
            ], true)) {
                continue;
            }

            if (str_starts_with($key, 'collection_') && str_ends_with($key, '_item_id')) {
                $collectionId = (int) (string) str($key)->after('collection_')->before('_item_id');
                $item = ProductCollectionItem::find($value);

                if ($item) {
                    $summary[] = [
                        'label' => 'Kolekcja',
                        'value' => $item->label,
                    ];
                }
                continue;
            }

            // 🔹 KOLEKCJA: wariant (kolor)
            if (str_starts_with($key, 'collection_') && str_ends_with($key, '_value_id')) {
                $variant = \App\Models\ProductCollectionItemValue::find($value);

                if ($variant) {
                    $summary[] = [
                        'label' => 'Wariant kolekcji',
                        'value' => $variant->label,
                    ];
                }
                continue;
            }

            // 🔹 FIELD_INPUT (np. wymiary)
            if (is_array($value)) {
                $attribute = $attributes->firstWhere('id', (int) $key);
                $rows = [];

                if ($attribute) {
                    foreach ($value as $valId => $valValue) {
                        if ($valValue === null) {
                            continue;
                        }

                        $valDef = $attribute->values->firstWhere('id', $valId);

                        if ($attribute->input_type === AttributeInputType::FIELD_INPUT) {
                            $label = $valDef->config['label'] ?? "Parametr {$valId}";
                        } else {
                            $label = $valDef->label ?? "Parametr {$valId}";
                        }

                        $unit = $valDef->config['unit'] ?? '';

                        $rows[] = $valValue ?
                            "{$label}: {$valValue}{$unit}" :
                            "{$label}: -";
                    }

                    if (!empty($rows)) {
                        $summary[] = [
                            'label' => $attribute->label,
                            'value' => $rows,
                        ];
                    }
                }
                continue;
            }

            $label = $attribute->label ?? $key;
            $selectedValue = $attribute?->values->firstWhere('id', (int)$value);
            $labelValue = $selectedValue?->label ?? $value;

            if ($attribute && $selectedValue) {
                // Pobierz dopłaty dla tej wartości atrybutu
                $modifiers = AttributeValuePriceModifier::query()
                    ->where('attribute_value_id', $selectedValue->id)
                    ->with(['conditions.attributeValues'])
                    ->get();

                $appliedModifiers = [];
                foreach ($modifiers as $modifier) {
                    if ($modifier->shouldApply($this->formData, $this->product, $width, $quantity)) {
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
                        ];
                    }
                }

                $summary[] = [
                    'label' => $label,
                    'value' => $labelValue,
                    'price_modifiers' => $appliedModifiers,
                ];
            }
        }

        if (!empty($summary)) {
            array_unshift($summary, [
                'label' => 'Produkt',
                'value' => $this->product->name,
            ]);
        }

        return $summary;
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

    protected function getHeightFromFormData(array $formData): ?float
    {
        if (!$this->product->height_attribute) {
            return null;
        }

        foreach ($formData as $key => $value) {
            if (!is_array($value)) {
                continue;
            }

            foreach ($value as $k => $v) {
                if ($k == $this->product->height_attribute) {
                    return (float)$v;
                }
            }
        }

        return null;
    }

    public function render()
    {
        return view('livewire.summary-box');
    }
}

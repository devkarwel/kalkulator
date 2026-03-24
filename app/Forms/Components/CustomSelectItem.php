<?php

namespace App\Forms\Components;

use App\Enums\AttributeInputVariant;
use Filament\Forms\Components\Field;

class CustomSelectItem extends Field
{
    protected string $view = 'filament.forms.components.custom-select-item';
    public ?string $variant = null;
    public array|\Closure $options = [];
    public ?string $tooltip = null;

    public function variant(AttributeInputVariant $variant): static
    {
        $this->variant = $this->setVariantStyle($variant);

        return $this;
    }

    public function getVariant(): string
    {
        return $this->variant;
    }

    public function options(array|\Closure $options): static
    {
        $this->options = $options;

        return $this;
    }

    public function getOptions(): array|\Closure
    {
        return $this->evaluate($this->options);
    }

    public function tooltip(?string $tooltip = null): static
    {
        $this->tooltip = $tooltip;

        return $this;
    }

    public function getTooltip(): ?string
    {
        return $this->tooltip;
    }

    protected function setVariantStyle(AttributeInputVariant $variant): string
    {
        return match ($variant) {
            AttributeInputVariant::SELECT_IMAGE_RECTANGLE => 'attribute-select__options--rectangle',
            AttributeInputVariant::SELECT_IMAGE_SQUARE => 'attribute-select__options--square',
            AttributeInputVariant::SELECT_IMAGE_SQUARE_SMALL => 'attribute-select__options--square-small',
            AttributeInputVariant::SELECT_IMAGE_ICON => 'attribute-select__options--icon',
            AttributeInputVariant::SELECT_IMAGE_CIRCLE => 'attribute-select__options--circle',
            AttributeInputVariant::SELECT_TEXT => 'attribute-select__options--inline',
            default => '',
        };
    }
}

<?php

namespace Database\Seeders\helpers;

use App\Enums\AttributeInputType;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

final class ProductAttributesSeeder
{
    public function __construct(
        protected readonly Model $model,
    ) {
    }

    public function insertAttributes(
        ?array $attributes = [],
        ?array $dependencies = [],
    ): void
    {
        foreach ($attributes as $attribute) {
            match ($attribute['input_type']) {
                AttributeInputType::FIELD_INPUT => $this->insertInput($attribute),
                default => null,
            };
        }
    }

    private function insertInput(array $attribute): void
    {
        $options = $attribute['options'] ?? null;
        $attrName = Str::slug($attribute['label']);
        $attributesMap = [];
        $valuesMap = [];
        dd($attribute);
        unset($attribute['options'], $attribute['dependencies']);

        $attr = $this->model->attributes()->create($attribute);


    }
}

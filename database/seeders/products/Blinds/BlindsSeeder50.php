<?php

namespace Database\Seeders\products\Blinds;

use App\Enums\AttributeInputType;
use App\Enums\AttributeSideColumn;
use App\Enums\PriceActionModifier;
use App\Enums\PriceTypeModifier;
use App\Models\Attribute;
use App\Models\AttributeDependency;
use App\Models\AttributeValue;
use App\Models\AttributeValuePriceModifier;
use App\Models\AttributeValuePriceModifierCondition;
use App\Models\PriceRange;
use App\Models\PriceRangeCondition;
use App\Models\PriceRangeModifier;
use App\Models\PriceRangeStep;
use App\Models\Product;
use App\Models\ProductCollection;
use App\Models\ProductCollectionItem;
use App\Models\ProductCollectionItemValue;
use Database\Seeders\helpers\UploadFileFromSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlindsSeeder50 extends Seeder
{
    public function run(): void
    {
        $productTitle = 'Żaluzje 50mm';
        $productSlug = Str::slug($productTitle);

        $product = Product::create([
            'name' => $productTitle,
            'slug' => $productSlug,
            'sort_order' => 4,
        ]);

        UploadFileFromSeeder::upload($product, 'zaluzje.png','cover');

        $this->seedAttributes($product);
        $this->seedPricesList($product);
        $this->seedPriceModifiers($product);

        UploadFileFromSeeder::clear();

        // powiazanie wymiarow
        $dimensions = AttributeValue::query()
            ->whereHas('attribute', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->whereIn('name', ['wymiar_a', 'wymiar_b', 'ilosc'])
            ->get();

        $product->width_attribute = $dimensions[0]->id;
        $product->height_attribute = $dimensions[1]->id;
        $product->quantity_attribute = $dimensions[2]->id;
        $product->update();
    }

    private function seedAttributes(Product $product): void
    {
        $attributesData = AttributeData50::get();
        $dependencies = AttributeData50::getDependency();

        foreach ($attributesData as $attribute) {
            $this->insertAttributeAndValues($product, $attribute);
        }

        if (count($dependencies) > 0) {
            $this->addDependencies($product->id, $dependencies);
        }
    }

    private function insertAttributeAndValues(Product $product, array $attribute): void
    {
        $options = $attribute['options'] ?? null;
        $attrName = Str::slug($attribute['label'], '_');

        unset($attribute['options'], $attribute['dependencies']);

        $attrData = array_merge($attribute, ['product_id' => $product->id, 'name' => $attrName]);

        $attr = $product->attributes()->create($attrData);

        if ($options) {
            foreach ($options as $option) {
                $valueImg = $option['img'] ?? null;
                $optionName = Str::slug($option['label'], '_');

                $attrVal = AttributeValue::create([
                    'attribute_id' => $attr->id,
                    'label' => $option['label'],
                    'name' => $optionName,
                    'value' => $optionName,
                    'sort_order' => $option['sort_order'] ?? 0,
                    'config' => $option['config'] ?? null,
                ]);

                if ($valueImg && file_exists('resources/tmp-img-seeder/' . $product->slug . '/' . $valueImg['file'])) {
                    UploadFileFromSeeder::upload(
                        $attrVal,
                        $valueImg['file'],
                        $valueImg['collection'],
                        $product->slug
                    );
                }
            }
        }
    }

    private function addDependencies(int $productId, array $dependencies): void
    {
        foreach ($dependencies as $dependency) {
            $conditions = $dependency['conditions'] ?? null;

            if ($conditions !== null) {
                $showAttrId = Attribute::query()
                    ->where('product_id', $productId)
                    ->where('name', $dependency['then_show_attr'])
                    ->value('id');

                $showValues = [];
                if (!empty($dependency['show_all_values'])) {
                    $showValues = AttributeValue::query()
                        ->where('attribute_id', $showAttrId)
                        ->pluck('name')
                        ->toArray();
                } else {
                    $showValues = $dependency['show_values'] ?? [];
                }

                foreach ($showValues as $showValueSlug) {
                    $showValId = AttributeValue::query()
                        ->where('attribute_id', $showAttrId)
                        ->where('name', Str::slug($showValueSlug, '_'))
                        ->value('id');

                    foreach ($conditions as $condition) {
                        $condAttrId = Attribute::query()
                            ->where('product_id', $productId)
                            ->where('name', $condition['attribute'])
                            ->value('id');

                        $condValId = AttributeValue::query()
                            ->where('attribute_id', $condAttrId)
                            ->where('name', Str::slug($condition['value'], '_'))
                            ->value('id');

                        AttributeDependency::create([
                            'product_id' => $productId,
                            'attribute_id' => $showAttrId,
                            'attribute_value_id' => $showValId,
                            'depends_on_attribute_id' => $condAttrId,
                            'depends_on_value_id' => $condValId,
                        ]);
                    }
                }

                continue;
            }

            $dependAttrId = Attribute::query()
                ->where('product_id', $productId)
                ->where('name', $dependency['if_selected_attr'])
                ->value('id');

            $dependAttrValId = AttributeValue::query()
                ->where('attribute_id', $dependAttrId)
                ->where('name', Str::slug($dependency['and_value'], '_'))
                ->value('id');

            $dependOnAttrId = Attribute::query()
                ->where('product_id', $productId)
                ->where('name', $dependency['then_show_attr'])
                ->value('id');

            if (!empty($dependency['show_all_values'])) {
                $showValues = AttributeValue::query()
                    ->where('attribute_id', $dependOnAttrId)
                    ->pluck('name')
                    ->toArray();
            } else {
                $showValues = $dependency['show_values'] ?? [$dependency['show_value']];
            }

            foreach ($showValues as $valueSlug) {
                $dependOnAttrValId = AttributeValue::query()
                    ->where('attribute_id', $dependOnAttrId)
                    ->where('name', Str::slug($valueSlug, '_'))
                    ->value('id');

                AttributeDependency::create([
                    'product_id' => $productId,
                    'attribute_id' => $dependOnAttrId,
                    'attribute_value_id' => $dependOnAttrValId,
                    'depends_on_attribute_id' => $dependAttrId,
                    'depends_on_value_id' => $dependAttrValId,
                ]);
            }
        }
    }

    private function seedPricesList(Product $product): void
    {
        $pricesListData[] = PriceListAluminiumPerforowana_50::get();
        $pricesListData[] = PriceListAluminiumStandard_I_50::get();
        $pricesListData[] = PriceListAluminiumStandard_II_50::get();
        $pricesListData[] = PriceListDrewnianaAfricashade_50::get();
        $pricesListData[] = PriceListDrewnianaBambusowa_50::get();
        $pricesListData[] = PriceListDrewnianaDrewnianaPure_50::get();
        $pricesListData[] = PriceListDrewnianaXs_50::get();

        foreach ($pricesListData as $entry) {
            $priceRange = PriceRange::create(['name' => $entry['name']]);

            // warunek: atrybut
            if (isset($entry['conditions']['attributes'])) {
                foreach ($entry['conditions']['attributes'] as $data) {
                    $attributeId = Attribute::where('name', $data['attribute'])->value('id');

                    $condition = PriceRangeCondition::create([
                        'price_range_id' => $priceRange->id,
                        'product_id' => $product->id,
                        'attribute_id' => $attributeId,
                    ]);

                    $valueIds = AttributeValue::whereIn('name', $data['attribute_values'])
                        ->get()
                        ->pluck('id')
                        ->toArray();

                    $condition->attributeValues()->sync($valueIds);
                }
            }

            // kroki cenowe
            foreach ($entry['price_list'] as $step) {
                PriceRangeStep::create([
                    'price_range_id' => $priceRange->id,
                    'min_width' => (float)$step['min_w'],
                    'max_width' => (float)$step['max_w'],
                    'min_height' => (float)$step['min_h'],
                    'max_height' => (float)$step['max_h'],
                    'price' => (float)$step['price'],
                ]);
            }
        }
    }

    /**
     * Dodaje dopłaty z warunkami dla wartości atrybutów
     */
    private function seedPriceModifiers(Product $product): void
    {
        // Pobierz atrybut rodzaj_drabinki
        $rodzajDrabinkiAttr = Attribute::where('product_id', $product->id)
            ->where('name', 'rodzaj_drabinki')
            ->first();

        if (!$rodzajDrabinkiAttr) {
            return;
        }

        // Pobierz wartość "Drabinka taśmowa"
        $drabinkaTasmowa = AttributeValue::where('attribute_id', $rodzajDrabinkiAttr->id)
            ->where('name', 'drabinka_tasmowa')
            ->first();

        if ($drabinkaTasmowa) {
            // DOPŁATA: Drabinka taśmowa - +5% ceny żaluzji (ceny bazowej)
            $modifierAluminium = AttributeValuePriceModifier::create([
                'attribute_value_id' => $drabinkaTasmowa->id,
                'value' => 5.00, // 5%
                'type' => PriceTypeModifier::PERCENT,
                'action' => PriceActionModifier::ADD,
                'multiply_by_quantity' => false, // Procent od ceny bazowej
            ]);

            // Pobierz atrybuty
            $rodzajZaluzjiAttr = Attribute::where('product_id', $product->id)
                ->where('name', 'rodzaj_zaluzji')
                ->first();
            
            $kolorLameliAttr = Attribute::where('product_id', $product->id)
                ->where('name', 'kolor_lameli')
                ->first();

            if ($rodzajZaluzjiAttr) {
                // Warunek 1: Drabinka taśmowa +5% dla żaluzji aluminiowych 50mm
                $zaluzjeAluminiowe = AttributeValue::where('attribute_id', $rodzajZaluzjiAttr->id)
                    ->where('name', 'zaluzje_aluminiowe_50_mm')
                    ->first();

                if ($zaluzjeAluminiowe) {
                    AttributeValuePriceModifierCondition::create([
                        'attribute_value_price_modifier_id' => $modifierAluminium->id,
                        'product_id' => $product->id,
                        'attribute_id' => $rodzajZaluzjiAttr->id,
                        'operator' => '=',
                    ])->attributeValues()->sync([$zaluzjeAluminiowe->id]);
                }

                // Warunek 2: Drabinka taśmowa +5% dla kolekcji XS (żaluzje drewniane)
                $zaluzjeDrewniane = AttributeValue::where('attribute_id', $rodzajZaluzjiAttr->id)
                    ->where('name', 'zaluzje_drewniane_50_mm')
                    ->first();
                
                if ($zaluzjeDrewniane && $kolorLameliAttr) {
                    // Drewniane kolekcje: drabinka taśmowa +70 zł/szt (flat, per piece)
                    $drewnianeKolekcje = ['xs', 'drewnianapure', 'bambusowa', 'africashade'];

                    foreach ($drewnianeKolekcje as $kolorName) {
                        $kolorVal = AttributeValue::where('attribute_id', $kolorLameliAttr->id)
                            ->where('name', $kolorName)
                            ->first();

                        if (!$kolorVal) {
                            continue;
                        }

                        $modifierDrewn = AttributeValuePriceModifier::create([
                            'attribute_value_id' => $drabinkaTasmowa->id,
                            'value' => 70.00,
                            'type' => PriceTypeModifier::AMOUNT,
                            'action' => PriceActionModifier::ADD,
                            'multiply_by_quantity' => true,
                        ]);

                        AttributeValuePriceModifierCondition::create([
                            'attribute_value_price_modifier_id' => $modifierDrewn->id,
                            'product_id' => $product->id,
                            'attribute_id' => $rodzajZaluzjiAttr->id,
                            'operator' => '=',
                        ])->attributeValues()->sync([$zaluzjeDrewniane->id]);

                        AttributeValuePriceModifierCondition::create([
                            'attribute_value_price_modifier_id' => $modifierDrewn->id,
                            'product_id' => $product->id,
                            'attribute_id' => $kolorLameliAttr->id,
                            'operator' => '=',
                        ])->attributeValues()->sync([$kolorVal->id]);
                    }

                    // Maskownica z boczkami dla kolekcji XS: +43 zł/szt
                    $kolorXs = AttributeValue::where('attribute_id', $kolorLameliAttr->id)
                        ->where('name', 'xs')
                        ->first();

                    if ($kolorXs) {
                        $maskownicaAttr = Attribute::where('product_id', $product->id)
                            ->where('name', 'maskownica')
                            ->first();

                        $maskownicaZBoczkami = $maskownicaAttr
                            ? AttributeValue::where('attribute_id', $maskownicaAttr->id)
                                ->where('name', 'maskownica_z_boczkami')
                                ->first()
                            : null;

                        if ($maskownicaZBoczkami) {
                            $modifierMaskownica = AttributeValuePriceModifier::create([
                                'attribute_value_id' => $maskownicaZBoczkami->id,
                                'value' => 43.00,
                                'type' => PriceTypeModifier::AMOUNT,
                                'action' => PriceActionModifier::ADD,
                                'multiply_by_quantity' => true,
                            ]);

                            AttributeValuePriceModifierCondition::create([
                                'attribute_value_price_modifier_id' => $modifierMaskownica->id,
                                'product_id' => $product->id,
                                'attribute_id' => $rodzajZaluzjiAttr->id,
                                'operator' => '=',
                            ])->attributeValues()->sync([$zaluzjeDrewniane->id]);

                            AttributeValuePriceModifierCondition::create([
                                'attribute_value_price_modifier_id' => $modifierMaskownica->id,
                                'product_id' => $product->id,
                                'attribute_id' => $kolorLameliAttr->id,
                                'operator' => '=',
                            ])->attributeValues()->sync([$kolorXs->id]);
                        }
                    }
                }
            }
        }
    }
}

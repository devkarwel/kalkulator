<?php

namespace Database\Seeders\products\Blinds;

use App\Enums\AttributeInputType;
use App\Enums\AttributeSideColumn;
use App\Models\Attribute;
use App\Models\AttributeDependency;
use App\Models\AttributeValue;
use App\Enums\PriceActionModifier;
use App\Enums\PriceTypeModifier;
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

class BlindsSeeder25 extends Seeder
{
    public function run(): void
    {
        $productTitle = 'Żaluzje 25mm';
        $productSlug = Str::slug($productTitle);

        $product = Product::create([
            'name' => $productTitle,
            'slug' => $productSlug,
            'sort_order' => 3,
        ]);

        UploadFileFromSeeder::upload($product, 'zaluzje.jpg','cover');

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
        $attributesData = AttributeData25::get();
        $dependencies = AttributeData25::getDependency();

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
        $pricesListData[] = PriceListAluminiumStandard_I_25::get();
        $pricesListData[] = PriceListAluminiumStandard_II_25::get();
        $pricesListData[] = PriceListDrewnianaBambus_25::get();
        $pricesListData[] = PriceListDrewnianaPure_25::get();

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
        // Pobierz atrybuty i wartości
        $rodzajZaluzjiAttr = Attribute::where('product_id', $product->id)
            ->where('name', 'rodzaj_zaluzji')
            ->first();
        
        $sposobMocowaniaAttr = Attribute::where('product_id', $product->id)
            ->where('name', 'sposob_mocowania')
            ->first();
        
        $rodzajMocowaniaAttr = Attribute::where('product_id', $product->id)
            ->where('name', 'rodzaj_mocowania')
            ->first();
        
        $rodzajProwadzeniaAttr = Attribute::where('product_id', $product->id)
            ->where('name', 'rodzaj_prowadzenia_bocznego')
            ->first();
        
        $typUchwytuAttr = Attribute::where('product_id', $product->id)
            ->where('name', 'typ_uchwytu_do_prowadzenia_bocznego')
            ->first();

        if (!$sposobMocowaniaAttr || !$rodzajMocowaniaAttr || !$rodzajProwadzeniaAttr || !$typUchwytuAttr) {
            return;
        }

        // Pobierz wartości rodzaju żaluzji
        $zaluzjeDrewniane = $rodzajZaluzjiAttr ? AttributeValue::where('attribute_id', $rodzajZaluzjiAttr->id)
            ->where('name', 'zaluzje_drewniane_25_mm')
            ->first() : null;
        
        $zaluzjeAluminiowe = $rodzajZaluzjiAttr ? AttributeValue::where('attribute_id', $rodzajZaluzjiAttr->id)
            ->where('name', 'zaluzje_aluminiowe_25_mm')
            ->first() : null;

        // Pobierz wartości atrybutów
        $montazWSwietleSzyby = AttributeValue::where('attribute_id', $sposobMocowaniaAttr->id)
            ->where('name', Str::slug('MONTAŻ W ŚWIETLE SZYBY', '_'))
            ->first();
        
        $montazNaRamie = AttributeValue::where('attribute_id', $sposobMocowaniaAttr->id)
            ->where('name', Str::slug('MONTAŻ NA RAMIE OKIENNEJ', '_'))
            ->first();

        $mocowanieWSwietleSzyby = AttributeValue::where('attribute_id', $rodzajMocowaniaAttr->id)
            ->where('name', Str::slug('MOCOWANIE RYNNY GÓRNEJ W ŚWIETLE SZYBY', '_'))
            ->first();
        
        $mocowanieNaRame = AttributeValue::where('attribute_id', $rodzajMocowaniaAttr->id)
            ->where('name', Str::slug('MOCOWANIE RYNNY GÓRNEJ NA RAMĘ OKIENNĄ', '_'))
            ->first();
        
        $mocowanieBezinwazyjne = AttributeValue::where('attribute_id', $rodzajMocowaniaAttr->id)
            ->where('name', Str::slug('MOCOWANIE BEZINWAZYJNE RYNNY GÓRNEJ', '_'))
            ->first();

        $zylka = AttributeValue::where('attribute_id', $rodzajProwadzeniaAttr->id)
            ->where('name', 'zylka')
            ->first();
        
        $linkaStalowa = AttributeValue::where('attribute_id', $rodzajProwadzeniaAttr->id)
            ->where('name', 'linka_stalowa')
            ->first();

        $mocowanieBezinwazyjneDoProwadzenia = AttributeValue::where('attribute_id', $typUchwytuAttr->id)
            ->where('name', Str::slug('MOCOWANIE BEZINWAZYJNE DO PROWADZENIA BOCZNEGO', '_'))
            ->first();

        // ============================================
        // DOPŁATY DLA ŻALUZJI DREWNIANYCH 25MM
        // ============================================
        
        if (!$zaluzjeDrewniane || !$sposobMocowaniaAttr || !$rodzajMocowaniaAttr || !$rodzajProwadzeniaAttr || !$typUchwytuAttr) {
            // Jeśli nie ma żaluzji drewnianych, przejdź do aluminiowych
        } else {
            // 1. DOPŁATA: Żyłka - 10 zł za komplet
            // Warunek: ŻALUZJE DREWNIANE + MONTAŻ W ŚWIETLE SZYBY + MOCOWANIE RYNNY GÓRNEJ W ŚWIETLE SZYBY + Żyłka
            if ($zylka && $montazWSwietleSzyby && $mocowanieWSwietleSzyby) {
                $modifier = AttributeValuePriceModifier::create([
                    'attribute_value_id' => $zylka->id,
                    'value' => 10.00,
                    'type' => PriceTypeModifier::AMOUNT,
                    'action' => PriceActionModifier::ADD,
                    'multiply_by_quantity' => true, // Za każdą sztukę produktu
                ]);

                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajZaluzjiAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$zaluzjeDrewniane->id]);

                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $sposobMocowaniaAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$montazWSwietleSzyby->id]);

                $condition2 = AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajMocowaniaAttr->id,
                    'operator' => '=',
                ]);
                $condition2->attributeValues()->sync([$mocowanieWSwietleSzyby->id]);
            }

            // 2. DOPŁATA: Linka stalowa - 26 zł za komplet
            // Warunek: ŻALUZJE DREWNIANE + MONTAŻ W ŚWIETLE SZYBY + MOCOWANIE RYNNY GÓRNEJ W ŚWIETLE SZYBY + Linka stalowa
            if ($linkaStalowa && $montazWSwietleSzyby && $mocowanieWSwietleSzyby) {
                $modifier = AttributeValuePriceModifier::create([
                    'attribute_value_id' => $linkaStalowa->id,
                    'value' => 26.00,
                    'type' => PriceTypeModifier::AMOUNT,
                    'action' => PriceActionModifier::ADD,
                    'multiply_by_quantity' => true,
                ]);

                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajZaluzjiAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$zaluzjeDrewniane->id]);

                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $sposobMocowaniaAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$montazWSwietleSzyby->id]);

                $condition2 = AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajMocowaniaAttr->id,
                    'operator' => '=',
                ]);
                $condition2->attributeValues()->sync([$mocowanieWSwietleSzyby->id]);
            }

            // 3. DOPŁATA: Żyłka - 10 zł za komplet
            // Warunek: ŻALUZJE DREWNIANE + MONTAŻ NA RAMIE OKIENNEJ + MOCOWANIE RYNNY GÓRNEJ NA RAMĘ OKIENNĄ + Żyłka
            if ($zylka && $montazNaRamie && $mocowanieNaRame) {
                $modifier = AttributeValuePriceModifier::create([
                    'attribute_value_id' => $zylka->id,
                    'value' => 10.00,
                    'type' => PriceTypeModifier::AMOUNT,
                    'action' => PriceActionModifier::ADD,
                    'multiply_by_quantity' => true,
                ]);

                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajZaluzjiAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$zaluzjeDrewniane->id]);

                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $sposobMocowaniaAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$montazNaRamie->id]);

                $condition2 = AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajMocowaniaAttr->id,
                    'operator' => '=',
                ]);
                $condition2->attributeValues()->sync([$mocowanieNaRame->id]);
            }

            // 4. DOPŁATA: Linka stalowa - 26 zł za komplet
            // Warunek: ŻALUZJE DREWNIANE + MONTAŻ NA RAMIE OKIENNEJ + MOCOWANIE RYNNY GÓRNEJ NA RAMĘ OKIENNĄ + Linka stalowa
            if ($linkaStalowa && $montazNaRamie && $mocowanieNaRame) {
                $modifier = AttributeValuePriceModifier::create([
                    'attribute_value_id' => $linkaStalowa->id,
                    'value' => 26.00,
                    'type' => PriceTypeModifier::AMOUNT,
                    'action' => PriceActionModifier::ADD,
                    'multiply_by_quantity' => true,
                ]);

                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajZaluzjiAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$zaluzjeDrewniane->id]);

                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $sposobMocowaniaAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$montazNaRamie->id]);

                $condition2 = AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajMocowaniaAttr->id,
                    'operator' => '=',
                ]);
                $condition2->attributeValues()->sync([$mocowanieNaRame->id]);
            }

            // 5. DOPŁATA: MOCOWANIE BEZINWAZYJNE RYNNY GÓRNEJ - 14 zł/szt (zależna od szerokości)
            // Warunek: ŻALUZJE DREWNIANE + MONTAŻ NA RAMIE OKIENNEJ + MOCOWANIE BEZINWAZYJNE RYNNY GÓRNEJ
            // Ilość zależna od szerokości: do 80cm - 2szt, do 130cm - 3szt, do 190cm - 4szt, do 250cm - 5szt, do 290cm - 6szt
            // Tworzymy osobne modyfikatory dla każdego zakresu szerokości
            if ($mocowanieBezinwazyjne && $montazNaRamie) {
                // Do 80cm - 2 sztuki (14 zł × 2 = 28 zł za komplet)
                $modifier1 = AttributeValuePriceModifier::create([
                    'attribute_value_id' => $mocowanieBezinwazyjne->id,
                    'value' => 28.00, // 14 zł × 2 szt
                    'type' => PriceTypeModifier::AMOUNT,
                    'action' => PriceActionModifier::ADD,
                    'multiply_by_quantity' => true, // Za każdą sztukę produktu
                ]);
                $condition1 = AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier1->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajZaluzjiAttr->id,
                    'operator' => '=',
                    'min_width' => 0.0, // Od 0cm
                    'max_width' => 80.0, // Do 80cm
                ]);
                $condition1->attributeValues()->sync([$zaluzjeDrewniane->id]);
                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier1->id,
                    'product_id' => $product->id,
                    'attribute_id' => $sposobMocowaniaAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$montazNaRamie->id]);

                // Do 130cm - 3 sztuki (14 zł × 3 = 42 zł za komplet)
                $modifier2 = AttributeValuePriceModifier::create([
                    'attribute_value_id' => $mocowanieBezinwazyjne->id,
                    'value' => 42.00, // 14 zł × 3 szt
                    'type' => PriceTypeModifier::AMOUNT,
                    'action' => PriceActionModifier::ADD,
                    'multiply_by_quantity' => true,
                ]);
                $condition2 = AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier2->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajZaluzjiAttr->id,
                    'operator' => '=',
                    'min_width' => 80.01,
                    'max_width' => 130.0,
                ]);
                $condition2->attributeValues()->sync([$zaluzjeDrewniane->id]);
                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier2->id,
                    'product_id' => $product->id,
                    'attribute_id' => $sposobMocowaniaAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$montazNaRamie->id]);

                // Do 190cm - 4 sztuki (14 zł × 4 = 56 zł za komplet)
                $modifier3 = AttributeValuePriceModifier::create([
                    'attribute_value_id' => $mocowanieBezinwazyjne->id,
                    'value' => 56.00, // 14 zł × 4 szt
                    'type' => PriceTypeModifier::AMOUNT,
                    'action' => PriceActionModifier::ADD,
                    'multiply_by_quantity' => true,
                ]);
                $condition3 = AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier3->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajZaluzjiAttr->id,
                    'operator' => '=',
                    'min_width' => 130.01,
                    'max_width' => 190.0,
                ]);
                $condition3->attributeValues()->sync([$zaluzjeDrewniane->id]);
                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier3->id,
                    'product_id' => $product->id,
                    'attribute_id' => $sposobMocowaniaAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$montazNaRamie->id]);

                // Do 250cm - 5 sztuk (14 zł × 5 = 70 zł za komplet)
                $modifier4 = AttributeValuePriceModifier::create([
                    'attribute_value_id' => $mocowanieBezinwazyjne->id,
                    'value' => 70.00, // 14 zł × 5 szt
                    'type' => PriceTypeModifier::AMOUNT,
                    'action' => PriceActionModifier::ADD,
                    'multiply_by_quantity' => true,
                ]);
                $condition4 = AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier4->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajZaluzjiAttr->id,
                    'operator' => '=',
                    'min_width' => 190.01,
                    'max_width' => 250.0,
                ]);
                $condition4->attributeValues()->sync([$zaluzjeDrewniane->id]);
                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier4->id,
                    'product_id' => $product->id,
                    'attribute_id' => $sposobMocowaniaAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$montazNaRamie->id]);

                // Do 290cm - 6 sztuk (14 zł × 6 = 84 zł za komplet)
                $modifier5 = AttributeValuePriceModifier::create([
                    'attribute_value_id' => $mocowanieBezinwazyjne->id,
                    'value' => 84.00, // 14 zł × 6 szt
                    'type' => PriceTypeModifier::AMOUNT,
                    'action' => PriceActionModifier::ADD,
                    'multiply_by_quantity' => true,
                ]);
                $condition5 = AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier5->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajZaluzjiAttr->id,
                    'operator' => '=',
                    'min_width' => 250.01,
                    'max_width' => 290.0,
                ]);
                $condition5->attributeValues()->sync([$zaluzjeDrewniane->id]);
                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier5->id,
                    'product_id' => $product->id,
                    'attribute_id' => $sposobMocowaniaAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$montazNaRamie->id]);
            }

            // 6. DOPŁATA: Żyłka - 10 zł za komplet
            // Warunek: ŻALUZJE DREWNIANE + MONTAŻ NA RAMIE OKIENNEJ + MOCOWANIE BEZINWAZYJNE RYNNY GÓRNEJ + Żyłka
            if ($zylka && $montazNaRamie && $mocowanieBezinwazyjne) {
                $modifier = AttributeValuePriceModifier::create([
                    'attribute_value_id' => $zylka->id,
                    'value' => 10.00,
                    'type' => PriceTypeModifier::AMOUNT,
                    'action' => PriceActionModifier::ADD,
                    'multiply_by_quantity' => true,
                ]);

                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajZaluzjiAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$zaluzjeDrewniane->id]);

                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $sposobMocowaniaAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$montazNaRamie->id]);

                $condition2 = AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajMocowaniaAttr->id,
                    'operator' => '=',
                ]);
                $condition2->attributeValues()->sync([$mocowanieBezinwazyjne->id]);
            }

            // 7. DOPŁATA: Linka stalowa - 26 zł za komplet
            // Warunek: ŻALUZJE DREWNIANE + MONTAŻ NA RAMIE OKIENNEJ + MOCOWANIE BEZINWAZYJNE RYNNY GÓRNEJ + Linka stalowa
            if ($linkaStalowa && $montazNaRamie && $mocowanieBezinwazyjne) {
                $modifier = AttributeValuePriceModifier::create([
                    'attribute_value_id' => $linkaStalowa->id,
                    'value' => 26.00,
                    'type' => PriceTypeModifier::AMOUNT,
                    'action' => PriceActionModifier::ADD,
                    'multiply_by_quantity' => true,
                ]);

                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajZaluzjiAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$zaluzjeDrewniane->id]);

                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $sposobMocowaniaAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$montazNaRamie->id]);

                $condition2 = AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajMocowaniaAttr->id,
                    'operator' => '=',
                ]);
                $condition2->attributeValues()->sync([$mocowanieBezinwazyjne->id]);
            }

            // 8. DOPŁATA: 30 zł/szt dla MOCOWANIE BEZINWAZYJNE DO PROWADZENIA BOCZNEGO + Żyłka
            // Warunek: ŻALUZJE DREWNIANE + MONTAŻ NA RAMIE OKIENNEJ + MOCOWANIE BEZINWAZYJNE RYNNY GÓRNEJ + MOCOWANIE BEZINWAZYJNE DO PROWADZENIA BOCZNEGO + Żyłka
            if ($mocowanieBezinwazyjneDoProwadzenia && $zylka && $montazNaRamie && $mocowanieBezinwazyjne) {
                $modifier = AttributeValuePriceModifier::create([
                    'attribute_value_id' => $mocowanieBezinwazyjneDoProwadzenia->id,
                    'value' => 30.00,
                    'type' => PriceTypeModifier::AMOUNT,
                    'action' => PriceActionModifier::ADD,
                    'multiply_by_quantity' => true, // Za sztukę
                ]);

                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajZaluzjiAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$zaluzjeDrewniane->id]);

                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $sposobMocowaniaAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$montazNaRamie->id]);

                $condition2 = AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajMocowaniaAttr->id,
                    'operator' => '=',
                ]);
                $condition2->attributeValues()->sync([$mocowanieBezinwazyjne->id]);

                $condition3 = AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajProwadzeniaAttr->id,
                    'operator' => '=',
                ]);
                $condition3->attributeValues()->sync([$zylka->id]);
            }

            // 9. DOPŁATA: 30 zł/szt dla MOCOWANIE BEZINWAZYJNE DO PROWADZENIA BOCZNEGO + Linka stalowa
            // Warunek: ŻALUZJE DREWNIANE + MONTAŻ NA RAMIE OKIENNEJ + MOCOWANIE BEZINWAZYJNE RYNNY GÓRNEJ + MOCOWANIE BEZINWAZYJNE DO PROWADZENIA BOCZNEGO + Linka stalowa
            if ($mocowanieBezinwazyjneDoProwadzenia && $linkaStalowa && $montazNaRamie && $mocowanieBezinwazyjne) {
                $modifier = AttributeValuePriceModifier::create([
                    'attribute_value_id' => $mocowanieBezinwazyjneDoProwadzenia->id,
                    'value' => 30.00,
                    'type' => PriceTypeModifier::AMOUNT,
                    'action' => PriceActionModifier::ADD,
                    'multiply_by_quantity' => true, // Za sztukę
                ]);

                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajZaluzjiAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$zaluzjeDrewniane->id]);

                AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $sposobMocowaniaAttr->id,
                    'operator' => '=',
                ])->attributeValues()->sync([$montazNaRamie->id]);

                $condition2 = AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajMocowaniaAttr->id,
                    'operator' => '=',
                ]);
                $condition2->attributeValues()->sync([$mocowanieBezinwazyjne->id]);

                $condition3 = AttributeValuePriceModifierCondition::create([
                    'attribute_value_price_modifier_id' => $modifier->id,
                    'product_id' => $product->id,
                    'attribute_id' => $rodzajProwadzeniaAttr->id,
                    'operator' => '=',
                ]);
                $condition3->attributeValues()->sync([$linkaStalowa->id]);
            }
        }

        // ============================================
        // DOPŁATY DLA ŻALUZJI ALUMINIOWYCH 25MM
        // ============================================
        
        if (!$zaluzjeAluminiowe || !$sposobMocowaniaAttr || !$rodzajMocowaniaAttr || !$rodzajProwadzeniaAttr || !$typUchwytuAttr) {
            return;
        }

        // 1. DOPŁATA: Żyłka - 10 zł za komplet
        // Warunek: ŻALUZJE ALUMINIOWE + MONTAŻ W ŚWIETLE SZYBY + MOCOWANIE RYNNY GÓRNEJ W ŚWIETLE SZYBY + Żyłka
        if ($zylka && $montazWSwietleSzyby && $mocowanieWSwietleSzyby) {
            $modifier = AttributeValuePriceModifier::create([
                'attribute_value_id' => $zylka->id,
                'value' => 10.00,
                'type' => PriceTypeModifier::AMOUNT,
                'action' => PriceActionModifier::ADD,
                'multiply_by_quantity' => false,
            ]);

            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajZaluzjiAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$zaluzjeAluminiowe->id]);

            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $sposobMocowaniaAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$montazWSwietleSzyby->id]);

            $condition2 = AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajMocowaniaAttr->id,
                'operator' => '=',
            ]);
            $condition2->attributeValues()->sync([$mocowanieWSwietleSzyby->id]);
        }

        // 2. DOPŁATA: Linka stalowa - 26 zł za komplet
        // Warunek: ŻALUZJE ALUMINIOWE + MONTAŻ W ŚWIETLE SZYBY + MOCOWANIE RYNNY GÓRNEJ W ŚWIETLE SZYBY + Linka stalowa
        if ($linkaStalowa && $montazWSwietleSzyby && $mocowanieWSwietleSzyby) {
            $modifier = AttributeValuePriceModifier::create([
                'attribute_value_id' => $linkaStalowa->id,
                'value' => 26.00,
                'type' => PriceTypeModifier::AMOUNT,
                'action' => PriceActionModifier::ADD,
                'multiply_by_quantity' => false,
            ]);

            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajZaluzjiAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$zaluzjeAluminiowe->id]);

            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $sposobMocowaniaAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$montazWSwietleSzyby->id]);

            $condition2 = AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajMocowaniaAttr->id,
                'operator' => '=',
            ]);
            $condition2->attributeValues()->sync([$mocowanieWSwietleSzyby->id]);
        }

        // 3. DOPŁATA: Żyłka - 10 zł za komplet
        // Warunek: ŻALUZJE ALUMINIOWE + MONTAŻ NA RAMIE OKIENNEJ + MOCOWANIE RYNNY GÓRNEJ NA RAMĘ OKIENNĄ + Żyłka
        if ($zylka && $montazNaRamie && $mocowanieNaRame) {
            $modifier = AttributeValuePriceModifier::create([
                'attribute_value_id' => $zylka->id,
                'value' => 10.00,
                'type' => PriceTypeModifier::AMOUNT,
                'action' => PriceActionModifier::ADD,
                'multiply_by_quantity' => false,
            ]);

            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajZaluzjiAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$zaluzjeAluminiowe->id]);

            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $sposobMocowaniaAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$montazNaRamie->id]);

            $condition2 = AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajMocowaniaAttr->id,
                'operator' => '=',
            ]);
            $condition2->attributeValues()->sync([$mocowanieNaRame->id]);
        }

        // 4. DOPŁATA: Linka stalowa - 26 zł za komplet
        // Warunek: ŻALUZJE ALUMINIOWE + MONTAŻ NA RAMIE OKIENNEJ + MOCOWANIE RYNNY GÓRNEJ NA RAMĘ OKIENNĄ + Linka stalowa
        if ($linkaStalowa && $montazNaRamie && $mocowanieNaRame) {
            $modifier = AttributeValuePriceModifier::create([
                'attribute_value_id' => $linkaStalowa->id,
                'value' => 26.00,
                'type' => PriceTypeModifier::AMOUNT,
                'action' => PriceActionModifier::ADD,
                'multiply_by_quantity' => false,
            ]);

            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajZaluzjiAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$zaluzjeAluminiowe->id]);

            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $sposobMocowaniaAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$montazNaRamie->id]);

            $condition2 = AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajMocowaniaAttr->id,
                'operator' => '=',
            ]);
            $condition2->attributeValues()->sync([$mocowanieNaRame->id]);
        }

        // 5. DOPŁATA: MOCOWANIE BEZINWAZYJNE RYNNY GÓRNEJ - 14 zł/szt (zależna od szerokości)
        // Warunek: ŻALUZJE ALUMINIOWE + MONTAŻ NA RAMIE OKIENNEJ + MOCOWANIE BEZINWAZYJNE RYNNY GÓRNEJ
        if ($mocowanieBezinwazyjne && $montazNaRamie) {
            // Do 80cm - 2 sztuki (14 zł × 2 = 28 zł za komplet)
            $modifier1 = AttributeValuePriceModifier::create([
                'attribute_value_id' => $mocowanieBezinwazyjne->id,
                'value' => 28.00,
                'type' => PriceTypeModifier::AMOUNT,
                'action' => PriceActionModifier::ADD,
                'multiply_by_quantity' => false,
            ]);
            $condition1 = AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier1->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajZaluzjiAttr->id,
                'operator' => '=',
                'min_width' => 0.0,
                'max_width' => 80.0,
            ]);
            $condition1->attributeValues()->sync([$zaluzjeAluminiowe->id]);
            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier1->id,
                'product_id' => $product->id,
                'attribute_id' => $sposobMocowaniaAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$montazNaRamie->id]);

            // Do 130cm - 3 sztuki (14 zł × 3 = 42 zł za komplet)
            $modifier2 = AttributeValuePriceModifier::create([
                'attribute_value_id' => $mocowanieBezinwazyjne->id,
                'value' => 42.00,
                'type' => PriceTypeModifier::AMOUNT,
                'action' => PriceActionModifier::ADD,
                'multiply_by_quantity' => false,
            ]);
            $condition2 = AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier2->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajZaluzjiAttr->id,
                'operator' => '=',
                'min_width' => 80.01,
                'max_width' => 130.0,
            ]);
            $condition2->attributeValues()->sync([$zaluzjeAluminiowe->id]);
            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier2->id,
                'product_id' => $product->id,
                'attribute_id' => $sposobMocowaniaAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$montazNaRamie->id]);

            // Do 190cm - 4 sztuki (14 zł × 4 = 56 zł za komplet)
            $modifier3 = AttributeValuePriceModifier::create([
                'attribute_value_id' => $mocowanieBezinwazyjne->id,
                'value' => 56.00,
                'type' => PriceTypeModifier::AMOUNT,
                'action' => PriceActionModifier::ADD,
                'multiply_by_quantity' => false,
            ]);
            $condition3 = AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier3->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajZaluzjiAttr->id,
                'operator' => '=',
                'min_width' => 130.01,
                'max_width' => 190.0,
            ]);
            $condition3->attributeValues()->sync([$zaluzjeAluminiowe->id]);
            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier3->id,
                'product_id' => $product->id,
                'attribute_id' => $sposobMocowaniaAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$montazNaRamie->id]);

            // Do 250cm - 5 sztuk (14 zł × 5 = 70 zł za komplet)
            $modifier4 = AttributeValuePriceModifier::create([
                'attribute_value_id' => $mocowanieBezinwazyjne->id,
                'value' => 70.00,
                'type' => PriceTypeModifier::AMOUNT,
                'action' => PriceActionModifier::ADD,
                'multiply_by_quantity' => false,
            ]);
            $condition4 = AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier4->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajZaluzjiAttr->id,
                'operator' => '=',
                'min_width' => 190.01,
                'max_width' => 250.0,
            ]);
            $condition4->attributeValues()->sync([$zaluzjeAluminiowe->id]);
            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier4->id,
                'product_id' => $product->id,
                'attribute_id' => $sposobMocowaniaAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$montazNaRamie->id]);

            // Do 290cm - 6 sztuk (14 zł × 6 = 84 zł za komplet)
            $modifier5 = AttributeValuePriceModifier::create([
                'attribute_value_id' => $mocowanieBezinwazyjne->id,
                'value' => 84.00,
                'type' => PriceTypeModifier::AMOUNT,
                'action' => PriceActionModifier::ADD,
                'multiply_by_quantity' => false,
            ]);
            $condition5 = AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier5->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajZaluzjiAttr->id,
                'operator' => '=',
                'min_width' => 250.01,
                'max_width' => 290.0,
            ]);
            $condition5->attributeValues()->sync([$zaluzjeAluminiowe->id]);
            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier5->id,
                'product_id' => $product->id,
                'attribute_id' => $sposobMocowaniaAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$montazNaRamie->id]);
        }

        // 6. DOPŁATA: Żyłka - 10 zł za komplet
        // Warunek: ŻALUZJE ALUMINIOWE + MONTAŻ NA RAMIE OKIENNEJ + MOCOWANIE BEZINWAZYJNE RYNNY GÓRNEJ + Żyłka
        if ($zylka && $montazNaRamie && $mocowanieBezinwazyjne) {
            $modifier = AttributeValuePriceModifier::create([
                'attribute_value_id' => $zylka->id,
                'value' => 10.00,
                'type' => PriceTypeModifier::AMOUNT,
                'action' => PriceActionModifier::ADD,
                'multiply_by_quantity' => false,
            ]);

            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajZaluzjiAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$zaluzjeAluminiowe->id]);

            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $sposobMocowaniaAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$montazNaRamie->id]);

            $condition2 = AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajMocowaniaAttr->id,
                'operator' => '=',
            ]);
            $condition2->attributeValues()->sync([$mocowanieBezinwazyjne->id]);
        }

        // 7. DOPŁATA: Linka stalowa - 26 zł za komplet
        // Warunek: ŻALUZJE ALUMINIOWE + MONTAŻ NA RAMIE OKIENNEJ + MOCOWANIE BEZINWAZYJNE RYNNY GÓRNEJ + Linka stalowa
        if ($linkaStalowa && $montazNaRamie && $mocowanieBezinwazyjne) {
            $modifier = AttributeValuePriceModifier::create([
                'attribute_value_id' => $linkaStalowa->id,
                'value' => 26.00,
                'type' => PriceTypeModifier::AMOUNT,
                'action' => PriceActionModifier::ADD,
                'multiply_by_quantity' => false,
            ]);

            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajZaluzjiAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$zaluzjeAluminiowe->id]);

            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $sposobMocowaniaAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$montazNaRamie->id]);

            $condition2 = AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajMocowaniaAttr->id,
                'operator' => '=',
            ]);
            $condition2->attributeValues()->sync([$mocowanieBezinwazyjne->id]);
        }

        // 8. DOPŁATA: 30 zł/szt dla MOCOWANIE BEZINWAZYJNE DO PROWADZENIA BOCZNEGO + Żyłka
        // Warunek: ŻALUZJE ALUMINIOWE + MONTAŻ NA RAMIE OKIENNEJ + MOCOWANIE BEZINWAZYJNE RYNNY GÓRNEJ + MOCOWANIE BEZINWAZYJNE DO PROWADZENIA BOCZNEGO + Żyłka
        if ($mocowanieBezinwazyjneDoProwadzenia && $zylka && $montazNaRamie && $mocowanieBezinwazyjne) {
            $modifier = AttributeValuePriceModifier::create([
                'attribute_value_id' => $mocowanieBezinwazyjneDoProwadzenia->id,
                'value' => 30.00,
                'type' => PriceTypeModifier::AMOUNT,
                'action' => PriceActionModifier::ADD,
                'multiply_by_quantity' => true, // Za sztukę
            ]);

            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajZaluzjiAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$zaluzjeAluminiowe->id]);

            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $sposobMocowaniaAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$montazNaRamie->id]);

            $condition2 = AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajMocowaniaAttr->id,
                'operator' => '=',
            ]);
            $condition2->attributeValues()->sync([$mocowanieBezinwazyjne->id]);

            $condition3 = AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajProwadzeniaAttr->id,
                'operator' => '=',
            ]);
            $condition3->attributeValues()->sync([$zylka->id]);
        }

        // 9. DOPŁATA: 30 zł/szt dla MOCOWANIE BEZINWAZYJNE DO PROWADZENIA BOCZNEGO + Linka stalowa
        // Warunek: ŻALUZJE ALUMINIOWE + MONTAŻ NA RAMIE OKIENNEJ + MOCOWANIE BEZINWAZYJNE RYNNY GÓRNEJ + MOCOWANIE BEZINWAZYJNE DO PROWADZENIA BOCZNEGO + Linka stalowa
        if ($mocowanieBezinwazyjneDoProwadzenia && $linkaStalowa && $montazNaRamie && $mocowanieBezinwazyjne) {
            $modifier = AttributeValuePriceModifier::create([
                'attribute_value_id' => $mocowanieBezinwazyjneDoProwadzenia->id,
                'value' => 30.00,
                'type' => PriceTypeModifier::AMOUNT,
                'action' => PriceActionModifier::ADD,
                'multiply_by_quantity' => true, // Za sztukę
            ]);

            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajZaluzjiAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$zaluzjeAluminiowe->id]);

            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $sposobMocowaniaAttr->id,
                'operator' => '=',
            ])->attributeValues()->sync([$montazNaRamie->id]);

            $condition2 = AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajMocowaniaAttr->id,
                'operator' => '=',
            ]);
            $condition2->attributeValues()->sync([$mocowanieBezinwazyjne->id]);

            $condition3 = AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id' => $product->id,
                'attribute_id' => $rodzajProwadzeniaAttr->id,
                'operator' => '=',
            ]);
            $condition3->attributeValues()->sync([$linkaStalowa->id]);
        }
    }
}

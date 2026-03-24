<?php

namespace Database\Seeders\products\PleatedBlinds;

use App\Models\Attribute;
use App\Models\AttributeDependency;
use App\Models\AttributeValue;
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

class PleatedBlindsSeeder extends Seeder
{
    public function run(): void
    {
        $productTitle = 'Rolety plisowane';
        $productSlug = Str::slug($productTitle);

        $product = Product::create([
            'name' => $productTitle,
            'slug' => $productSlug,
            'sort_order' => 2,
        ]);

        UploadFileFromSeeder::upload($product, 'roleta-plisowana.jpg','cover');

        $this->seedCollections($product);
        $this->seedAttributes($product);
        $this->seedPricesList($product);

        UploadFileFromSeeder::clear();

        // powiazanie wymiarow
        $dimensions = AttributeValue::query()
            ->whereHas('attribute', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->whereIn('name', ['wymiar_s', 'wymiar_w', 'ilosc'])
            ->get();

        $product->width_attribute = $dimensions[0]->id;
        $product->height_attribute = $dimensions[1]->id;
        $product->quantity_attribute = $dimensions[2]->id;
        $product->update();
    }

    private function seedAttributes(Product $product): void
    {
        $attributesData = AttributeData::get();
        $dependencies = AttributeData::getDependency();

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

                if ($valueImg) {
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

    private function seedCollections(Product $product): void
    {
        $collectionsData = CollectionData::get();

        foreach ($collectionsData as $collectionGroupData) {
            $collectionGroup = ProductCollection::create([
                'product_id' => $product->id,
                'label' => $collectionGroupData['label'],
                'name' => Str::slug($collectionGroupData['label'], '_'),
            ]);

            $joinAttribute = $collectionGroupData['attribute'] ?? null;
            if ($joinAttribute) {
                $attr = Attribute::create([
                    'product_id' => $product->id,
                    'required' => true,
                    'label' => $joinAttribute['label'],
                    'name' => Str::slug($joinAttribute['label'], '_'),
                    'input_type' => $joinAttribute['input_type'],
                    'input_variant' => $joinAttribute['input_variant'],
                    'column_side' =>$joinAttribute['column_side'],
                    'nr_step' => $joinAttribute['nr_step'],
                    'sort_order' => 1
                ]);

                $attrVal = AttributeValue::create([
                    'attribute_id' => $attr->id,
                    'label' => $collectionGroupData['label'],
                    'name' => Str::slug($collectionGroupData['label'], '_'),
                    'value' => $collectionGroup->id,
                    'collection_id' => $collectionGroup->id,
                    'sort_order' => 1,
                ]);
            }

            foreach ($collectionGroupData['items'] as $index => $collection) {
                $collectionObj = ProductCollectionItem::create([
                    'product_collection_id' => $collectionGroup->id,
                    'label' => $collection['name'],
                    'name' => Str::slug($collection['name'], '_'),
                    'value' => Str::slug($collection['name'], '_'),
                    'sort_order' => (int)$index + 1,
                ]);

                UploadFileFromSeeder::upload(
                    $collectionObj,
                    "collections/{$collection['cover_img']}",
                    'collection_item',
                    $product->slug
                );

                foreach ($collection['items'] as $itemIndex => $collectionItem) {
                    $itemValue = ProductCollectionItemValue::create([
                        'product_collection_item_id' => $collectionObj->id,
                        'label' => $collectionItem['name'],
                        'value' => Str::slug($collectionItem['name'], '_'),
                        'name' => Str::slug($collectionItem['name'], '_'),
                        'sort_order' => (int)$itemIndex + 1,
                    ]);

                    UploadFileFromSeeder::upload(
                        $itemValue,
                        "collections/{$collectionItem['img']}",
                        'collection_item_value',
                        $product->slug
                    );
                }
            }
        }
    }

    private function seedPricesList(Product $product): void
    {
        $pricesListData = PriceListData::get();

        foreach ($pricesListData as $entry) {
            $priceRange = PriceRange::create(['name' => $entry['name']]);

            // warunki: kolekcje
            if (isset($entry['conditions']['collections']) && is_array($entry['conditions']['collections'])) {
                foreach ($entry['conditions']['collections'] as $data) {
                    $productId = $product->id;
                    $attributeId = Attribute::where('name', $data['attribute'])->value('id');
                    $collectionId = ProductCollection::where('name', $data['collection'])->value('id');
                    $itemId = ProductCollectionItem::where('name', $data['collection_item'])
                        ->where('product_collection_id', $collectionId)
                        ->value('id');

                    PriceRangeCondition::create([
                        'price_range_id' => $priceRange->id,
                        'product_id' => $productId,
                        'attribute_id' => $attributeId,
                        'product_collection_id' => $collectionId,
                        'product_collection_item_id' => $itemId,
                    ]);
                }
            }

            // warunek: atrybut
            if (isset($entry['conditions']['attribute'])) {
                $data = $entry['conditions']['attribute'];

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

            // modyfikatory cenowe
            if (isset($entry['conditions']['modifiers'])) {
                foreach ($entry['conditions']['modifiers'] as $modifier) {
                    $attrId = Attribute::where('name', $modifier['attribute_name'])
                        ->get()
                        ->value('id');
                    $attrValId = AttributeValue::where('name', $modifier['attribute_value_name'])
                        ->get()
                        ->value('id');

                    PriceRangeModifier::create([
                        'price_range_id' => $priceRange->id,
                        'attribute_id' => $attrId,
                        'attribute_value_id' => $attrValId,
                        'value' => $modifier['value'],
                        'type' => $modifier['type'],
                        'action' => $modifier['action'],
                    ]);
                }
            }

            // kroki cenowe
            foreach ($entry['price_list'] as $step) {
                PriceRangeStep::create([
                    'price_range_id' => $priceRange->id,
                    'min_width' => $step['min_w'],
                    'max_width' => $step['max_w'],
                    'min_height' => $step['min_h'],
                    'max_height' => $step['max_h'],
                    'price' => $step['price'],
                ]);
            }
        }
    }
}

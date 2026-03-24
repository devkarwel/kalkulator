<?php

namespace Database\Seeders;

use App\Enums\AttributeInputType;
use App\Enums\AttributeInputVariant;
use App\Enums\AttributeSideColumn;
use App\Enums\PriceActionModifier;
use App\Enums\PriceTypeModifier;
use App\Models\Attribute;
use App\Models\AttributeDependency;
use App\Models\AttributeValue;
use App\Models\AttributeValuePriceModifier;
use App\Models\AttributeValuePriceModifierCondition;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Patch seeder dla istniejącej bazy danych.
 *
 * Uruchom jednorazowo:
 *   sail artisan db:seed --class=BlindsPatchSeeder
 *
 * Co robi:
 *  1. Żaluzje 25mm — ustawia prowadzenie_boczne jako wymagane (required=true)
 *  2. Żaluzje 50mm — zastępuje modyfikator drabinka taśmowa +5% (dla kolekcji XS)
 *     modyfikatorem +70 zł/szt
 *  3. Żaluzje 50mm — dodaje modyfikatory drabinka taśmowa +70 zł/szt
 *     dla kolekcji bambusowa, drewniana/pure, africa/shade
 *  4. Żaluzje 50mm — dodaje atrybut "Maskownica" (bez boczków / z boczkami)
 *     widoczny tylko dla kolekcji XS
 *  5. Żaluzje 50mm — dodaje modyfikator maskownica z boczkami +43 zł/szt dla XS
 */
class BlindsPatchSeeder extends Seeder
{
    public function run(): void
    {
        $this->patchBlinds25();
        $this->patchBlinds50();
    }

    // =========================================================================
    // Żaluzje 25mm — prowadzenie boczne required=true
    // =========================================================================

    private function patchBlinds25(): void
    {
        $product = Product::where('name', 'Żaluzje 25mm')->first();
        if (! $product) {
            $this->command?->warn('Produkt "Żaluzje 25mm" nie znaleziony — pomijam.');
            return;
        }

        $updated = Attribute::where('product_id', $product->id)
            ->where('name', 'rodzaj_prowadzenia_bocznego')
            ->where('required', false)
            ->update(['required' => true]);

        if ($updated) {
            $this->command?->info('✓ prowadzenie_boczne ustawione jako wymagane (żaluzje 25mm).');
        } else {
            $this->command?->line('  prowadzenie_boczne już było wymagane — pomijam.');
        }
    }

    // =========================================================================
    // Żaluzje 50mm
    // =========================================================================

    private function patchBlinds50(): void
    {
        $product = Product::where('name', 'Żaluzje 50mm')->first();
        if (! $product) {
            $this->command?->warn('Produkt "Żaluzje 50mm" nie znaleziony — pomijam.');
            return;
        }

        $rodzajDrabinkiAttr = Attribute::where('product_id', $product->id)
            ->where('name', 'rodzaj_drabinki')
            ->first();

        $kolorLameliAttr = Attribute::where('product_id', $product->id)
            ->where('name', 'kolor_lameli')
            ->first();

        $rodzajZaluzjiAttr = Attribute::where('product_id', $product->id)
            ->where('name', 'rodzaj_zaluzji')
            ->first();

        if (! $rodzajDrabinkiAttr || ! $kolorLameliAttr || ! $rodzajZaluzjiAttr) {
            $this->command?->warn('Brakujące atrybuty dla żaluzji 50mm — pomijam patch drabinki.');
            return;
        }

        $drabinkaTasmowa = AttributeValue::where('attribute_id', $rodzajDrabinkiAttr->id)
            ->where('name', 'drabinka_tasmowa')
            ->first();

        $zaluzjeDrewniane = AttributeValue::where('attribute_id', $rodzajZaluzjiAttr->id)
            ->where('name', 'zaluzje_drewniane_50_mm')
            ->first();

        if ($drabinkaTasmowa && $zaluzjeDrewniane) {
            $this->removeXsPercentModifier($drabinkaTasmowa, $kolorLameliAttr, $product->id);
            $this->addDrewnianeDrabinkaModifiers($product, $drabinkaTasmowa, $zaluzjeDrewniane, $kolorLameliAttr, $rodzajZaluzjiAttr);
        }

        $this->addOrSkipMaskownicaAttribute($product, $zaluzjeDrewniane, $kolorLameliAttr, $rodzajZaluzjiAttr);
    }

    /**
     * Usuwa stary modyfikator procentowy (+5%) dla drabinki taśmowej + kolekcja XS.
     */
    private function removeXsPercentModifier(
        AttributeValue $drabinkaTasmowa,
        Attribute $kolorLameliAttr,
        int $productId
    ): void {
        $kolorXs = AttributeValue::where('attribute_id', $kolorLameliAttr->id)
            ->where('name', 'xs')
            ->first();

        if (! $kolorXs) {
            return;
        }

        // Znajdź ID warunków, które odwołują się do wartości XS
        $conditionIds = DB::table('attribute_value_price_modifier_condition_attribute_value')
            ->where('attribute_value_id', $kolorXs->id)
            ->pluck('attribute_value_price_modifier_condition_id');

        if ($conditionIds->isEmpty()) {
            return;
        }

        // Znajdź ID modyfikatorów powiązanych z tymi warunkami
        $modifierIds = AttributeValuePriceModifierCondition::whereIn('id', $conditionIds)
            ->where('attribute_id', $kolorLameliAttr->id)
            ->pluck('attribute_value_price_modifier_id');

        if ($modifierIds->isEmpty()) {
            return;
        }

        // Ogranicz do modyfikatorów procentowych dla drabinki taśmowej
        $toDelete = AttributeValuePriceModifier::whereIn('id', $modifierIds)
            ->where('attribute_value_id', $drabinkaTasmowa->id)
            ->where('type', PriceTypeModifier::PERCENT)
            ->get();

        foreach ($toDelete as $modifier) {
            $modifier->conditions->each(function (AttributeValuePriceModifierCondition $cond) {
                $cond->attributeValues()->detach();
                $cond->delete();
            });
            $modifier->delete();
        }

        if ($toDelete->isNotEmpty()) {
            $this->command?->info("✓ Usunięto {$toDelete->count()} stary modyfikator % dla drabinki taśmowej + XS.");
        }
    }

    /**
     * Dodaje modyfikatory +70 zł/szt dla drabinki taśmowej w kolekcjach drewnianych.
     * Pomija kolekcję jeśli modifier już istnieje.
     */
    private function addDrewnianeDrabinkaModifiers(
        Product $product,
        AttributeValue $drabinkaTasmowa,
        AttributeValue $zaluzjeDrewniane,
        Attribute $kolorLameliAttr,
        Attribute $rodzajZaluzjiAttr
    ): void {
        $kolekcjeMap = [
            'xs'           => 'XS',
            'drewnianapure'=> 'Drewniana/Pure',
            'bambusowa'    => 'Bambusowa',
            'africashade'  => 'Africa/Shade',
        ];

        foreach ($kolekcjeMap as $colorSlug => $colorLabel) {
            $kolorVal = AttributeValue::where('attribute_id', $kolorLameliAttr->id)
                ->where('name', $colorSlug)
                ->first();

            if (! $kolorVal) {
                $this->command?->warn("  Nie znaleziono wartości kolor_lameli=\"{$colorSlug}\" — pomijam.");
                continue;
            }

            // Sprawdź czy modifier już istnieje (drabinka_tasmowa + ta kolekcja + AMOUNT)
            $alreadyExists = $this->modifierExists(
                $drabinkaTasmowa->id,
                PriceTypeModifier::AMOUNT,
                $kolorLameliAttr->id,
                $kolorVal->id,
                $product->id
            );

            if ($alreadyExists) {
                $this->command?->line("  Modifier drabinka taśmowa +70 zł dla \"{$colorLabel}\" już istnieje — pomijam.");
                continue;
            }

            $modifier = AttributeValuePriceModifier::create([
                'attribute_value_id' => $drabinkaTasmowa->id,
                'value'              => 70.00,
                'type'               => PriceTypeModifier::AMOUNT,
                'action'             => PriceActionModifier::ADD,
                'multiply_by_quantity' => true,
            ]);

            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id'  => $product->id,
                'attribute_id' => $rodzajZaluzjiAttr->id,
                'operator'    => '=',
            ])->attributeValues()->sync([$zaluzjeDrewniane->id]);

            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifier->id,
                'product_id'  => $product->id,
                'attribute_id' => $kolorLameliAttr->id,
                'operator'    => '=',
            ])->attributeValues()->sync([$kolorVal->id]);

            $this->command?->info("✓ Dodano modyfikator: drabinka taśmowa +70 zł/szt dla kolekcji \"{$colorLabel}\".");
        }
    }

    /**
     * Dodaje atrybut "Maskownica" do żaluzji 50mm (jeśli jeszcze nie istnieje),
     * tworzy zależności oraz modyfikator ceny.
     */
    private function addOrSkipMaskownicaAttribute(
        Product $product,
        ?AttributeValue $zaluzjeDrewniane,
        Attribute $kolorLameliAttr,
        Attribute $rodzajZaluzjiAttr
    ): void {
        $existing = Attribute::where('product_id', $product->id)
            ->where('name', 'maskownica')
            ->first();

        if ($existing) {
            $this->command?->line('  Atrybut "maskownica" już istnieje — pomijam.');
            return;
        }

        $maskownicaAttr = Attribute::create([
            'product_id'    => $product->id,
            'name'          => 'maskownica',
            'label'         => 'Maskownica',
            'required'      => true,
            'input_type'    => AttributeInputType::SELECT_INPUT,
            'input_variant' => AttributeInputVariant::SELECT_TEXT,
            'column_side'   => AttributeSideColumn::COLUMN_LEFT,
            'nr_step'       => 3,
            'sort_order'    => 2,
            'is_active'     => true,
        ]);

        $bezBoczkow = AttributeValue::create([
            'attribute_id' => $maskownicaAttr->id,
            'name'         => 'maskownica_bez_boczkow',
            'label'        => 'Maskownica bez boczków',
            'value'        => 'maskownica_bez_boczkow',
            'sort_order'   => 1,
        ]);

        $zBoczkami = AttributeValue::create([
            'attribute_id' => $maskownicaAttr->id,
            'name'         => 'maskownica_z_boczkami',
            'label'        => 'Maskownica z boczkami',
            'value'        => 'maskownica_z_boczkami',
            'sort_order'   => 2,
            'config'       => [
                'has_extra_config' => true,
                'tooltip'          => 'za dopłatą 43 zł/szt',
            ],
        ]);

        $this->command?->info('✓ Dodano atrybut "Maskownica" z opcjami bez/z boczkami.');

        // --- Zależności: maskownica widoczna tylko dla kolekcji XS ---
        $kolorXs = AttributeValue::where('attribute_id', $kolorLameliAttr->id)
            ->where('name', 'xs')
            ->first();

        if ($kolorXs && $zaluzjeDrewniane) {
            foreach ([$bezBoczkow, $zBoczkami] as $valueModel) {
                AttributeDependency::create([
                    'product_id'              => $product->id,
                    'attribute_id'            => $maskownicaAttr->id,
                    'attribute_value_id'      => $valueModel->id,
                    'depends_on_attribute_id' => $rodzajZaluzjiAttr->id,
                    'depends_on_value_id'     => $zaluzjeDrewniane->id,
                ]);

                AttributeDependency::create([
                    'product_id'              => $product->id,
                    'attribute_id'            => $maskownicaAttr->id,
                    'attribute_value_id'      => $valueModel->id,
                    'depends_on_attribute_id' => $kolorLameliAttr->id,
                    'depends_on_value_id'     => $kolorXs->id,
                ]);
            }
            $this->command?->info('✓ Dodano zależności: maskownica widoczna tylko przy kolekcji XS.');
        }

        // --- Modyfikator: maskownica z boczkami +43 zł/szt dla XS ---
        if ($kolorXs && $zaluzjeDrewniane) {
            $modifierMaskownica = AttributeValuePriceModifier::create([
                'attribute_value_id'   => $zBoczkami->id,
                'value'                => 43.00,
                'type'                 => PriceTypeModifier::AMOUNT,
                'action'               => PriceActionModifier::ADD,
                'multiply_by_quantity' => true,
            ]);

            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifierMaskownica->id,
                'product_id'  => $product->id,
                'attribute_id' => $rodzajZaluzjiAttr->id,
                'operator'    => '=',
            ])->attributeValues()->sync([$zaluzjeDrewniane->id]);

            AttributeValuePriceModifierCondition::create([
                'attribute_value_price_modifier_id' => $modifierMaskownica->id,
                'product_id'  => $product->id,
                'attribute_id' => $kolorLameliAttr->id,
                'operator'    => '=',
            ])->attributeValues()->sync([$kolorXs->id]);

            $this->command?->info('✓ Dodano modyfikator: maskownica z boczkami +43 zł/szt dla kolekcji XS.');
        }
    }

    /**
     * Sprawdza czy modifier (AMOUNT) dla danej wartości atrybutu już istnieje
     * w połączeniu z określoną wartością kolor_lameli.
     */
    private function modifierExists(
        int $attributeValueId,
        PriceTypeModifier $type,
        int $kolorLameliAttrId,
        int $kolorValueId,
        int $productId
    ): bool {
        $conditionIds = DB::table('attribute_value_price_modifier_condition_attribute_value')
            ->where('attribute_value_id', $kolorValueId)
            ->pluck('attribute_value_price_modifier_condition_id');

        if ($conditionIds->isEmpty()) {
            return false;
        }

        $modifierIds = AttributeValuePriceModifierCondition::whereIn('id', $conditionIds)
            ->where('attribute_id', $kolorLameliAttrId)
            ->where('product_id', $productId)
            ->pluck('attribute_value_price_modifier_id');

        if ($modifierIds->isEmpty()) {
            return false;
        }

        return AttributeValuePriceModifier::whereIn('id', $modifierIds)
            ->where('attribute_value_id', $attributeValueId)
            ->where('type', $type)
            ->exists();
    }
}

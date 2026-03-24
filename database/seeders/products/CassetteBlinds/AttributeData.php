<?php

namespace Database\Seeders\products\CassetteBlinds;

use App\Enums\AttributeInputType;
use App\Enums\AttributeInputVariant;
use App\Enums\AttributeSideColumn;
use App\Enums\Unit;
use Illuminate\Support\Str;

final class AttributeData
{
    public static function getDependency(): array
    {
        return [
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_kasety', 'value' => Str::slug(strtolower('Kaseta płaska'), '_')],
                ],
                'then_show_attr' => 'wymiar_grafika',
                'show_values' => ['wymiar_grafika_plaska'],
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_kasety', 'value' => Str::slug(strtolower('Kaseta płaska'), '_')],
                ],
                'then_show_attr' => 'wymiar_opis',
                'show_values' => ['ograniczenia_wymiarow_plaska'],
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_kasety', 'value' => Str::slug(strtolower('Kaseta przestrzenna'), '_')],
                ],
                'then_show_attr' => 'wymiar_grafika',
                'show_values' => ['wymiar_grafika_przestrzenna'],
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_kasety', 'value' => Str::slug(strtolower('Kaseta przestrzenna'), '_')],
                ],
                'then_show_attr' => 'wymiar_opis',
                'show_values' => ['ograniczenia_wymiarow_przestrzenna'],
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_kasety', 'value' => Str::slug(strtolower('Kaseta przestrzenna'), '_')],
                ],
                'then_show_attr' => 'wymiar_opis',
                'show_values' => ['ograniczenia_wymiarow_przestrzenna'],
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_kasety', 'value' => Str::slug(strtolower('Kaseta płaska'), '_')],
                ],
                'then_show_attr' => 'wymiary',
                'show_values' => ['pomiar_d', 'pomiar_e', 'pomiar_f'],
            ],
        ];
    }

    public static function get(): array
    {
        return [
            [
                'name' => 'rodzaj_kasety',
                'label' => 'Rodzaj Kasety',
                'required' => true,
                'input_type' => AttributeInputType::SELECT_INPUT,
                'input_variant' => AttributeInputVariant::SELECT_IMAGE_ICON,
                'column_side' => AttributeSideColumn::COLUMN_LEFT,
                'nr_step' => 1,
                'sort_order' => 1,
                'options' => [
                    [
                        'label' => 'Kaseta płaska',
                        'img' => [
                            'file' => 'attributes/kasetki_plaskie_profil.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Kaseta przestrzenna',
                        'img' => [
                            'file' => 'attributes/kasetki_przestrzenne_profil.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 2,
                    ]
                ],
            ],
            [
                'name' => 'rodzaj_i_kolor_osprzetu',
                'label' => 'Rodzaj i kolor osprzętu',
                'required' => true,
                'input_type' => AttributeInputType::SELECT_INPUT,
                'input_variant' => AttributeInputVariant::SELECT_IMAGE_CIRCLE,
                'column_side' => AttributeSideColumn::COLUMN_RIGHT,
                'nr_step' => 1,
                'sort_order' => 1,
                'options' => [
                    [
                        'label' => 'Biały PCV',
                        'img' => [
                            'file' => 'attributes/kolor_bialy.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Biały Aluminium',
                        'img' => [
                            'file' => 'attributes/bialy-aluminium.png',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 2,
                    ],
                    [
                        'label' => 'Orzech Aluminium',
                        'img' => [
                            'file' => 'attributes/kolor_orzech.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 3,
                    ],
                    [
                        'label' => 'Dąb jasny Aluminium',
                        'img' => [
                            'file' => 'attributes/kolor_dab_jasny.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 4,
                    ],
                    [
                        'label' => 'Dąb ciemny Aluminium',
                        'img' => [
                            'file' => 'attributes/kolor_dab_ciemny.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 5,
                    ],
                ],
            ],
            [
                'name' => 'wymiary',
                'label' => 'Wymiary',
                'required' => true,
                'input_type' => AttributeInputType::FIELD_INPUT,
                'input_variant' => AttributeInputVariant::INPUT_NUMBER,
                'column_side' => AttributeSideColumn::COLUMN_LEFT,
                'nr_step' => 3,
                'sort_order' => 1,
                'options' => [
                    [
                        'label' => 'Pomiar A',
                        'config' => [
                            'required' => true,
                            'label' => 'Wymiar A',
                            'placeholder' => '-',
                            'default_value' => null,
                            'tooltip' => 'Szerokość szyby z listwami przyszybowymi (A)',
                            'unit' => Unit::CM,
                            'min_value' => 0,
                            'max_value' => 220,
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Pomiar B',
                        'config' => [
                            'required' => true,
                            'label' => 'Wymiar B',
                            'placeholder' => '-',
                            'default_value' => null,
                            'tooltip' => null,
                            'unit' => Unit::CM,
                            'min_value' => 0,
                            'max_value' => 220,
                        ],
                        'sort_order' => 2,
                    ],
                    [
                        'label' => 'Pomiar C',
                        'config' => [
                            'required' => true,
                            'label' => 'Wymiar C',
                            'placeholder' => '-',
                            'default_value' => null,
                            'tooltip' => 'Szerokość od klamki do wymiaru A (przełamania), zalecana odległość min 1,5 cm',
                            'unit' => Unit::CM,
                            'min_value' => 0,
                            'max_value' => 220,
                        ],
                        'sort_order' => 3,
                    ],
                    [
                        'label' => 'Pomiar D',
                        'config' => [
                            'required' => true,
                            'label' => 'Wymiar D',
                            'placeholder' => '-',
                            'default_value' => null,
                            'tooltip' => null,
                            'unit' => Unit::CM,
                            'min_value' => 0,
                            'max_value' => 220,
                        ],
                        'sort_order' => 3,
                    ],
                    [
                        'label' => 'Pomiar E',
                        'config' => [
                            'required' => true,
                            'label' => 'Wymiar E',
                            'placeholder' => '-',
                            'default_value' => null,
                            'tooltip' => null,
                            'unit' => Unit::CM,
                            'min_value' => 0,
                            'max_value' => 220,
                        ],
                        'sort_order' => 3,
                    ],
                    [
                        'label' => 'Pomiar F',
                        'config' => [
                            'required' => true,
                            'label' => 'Wymiar F',
                            'placeholder' => '-',
                            'default_value' => null,
                            'tooltip' => 'Pole wymiar F musi wynosić co najmniej 1 cm',
                            'unit' => Unit::CM,
                            'min_value' => 1,
                            'max_value' => 220,
                        ],
                        'sort_order' => 3,
                    ],
                ]
            ],
            [
                'name' => 'sterowanie',
                'label' => 'Sterowanie',
                'required' => true,
                'input_type' => AttributeInputType::SELECT_INPUT,
                'input_variant' => AttributeInputVariant::SELECT_TEXT,
                'column_side' => AttributeSideColumn::COLUMN_LEFT,
                'nr_step' => 3,
                'sort_order' => 2,
                'options' => [
                    [
                        'label' => 'Prawa',
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Lewa',
                        'sort_order' => 2,
                    ],
                ],
            ],
            [
                'name' => 'ilosc',
                'label' => 'Ilość',
                'required' => true,
                'input_type' => AttributeInputType::FIELD_INPUT,
                'input_variant' => AttributeInputVariant::INPUT_NUMBER,
                'column_side' => AttributeSideColumn::COLUMN_LEFT,
                'nr_step' => 3,
                'sort_order' => 3,
                'options' => [
                    [
                        'label' => 'Ilość',
                        'config' => [
                            'required' => true,
                            'label' => 'Zamawiana ilość',
                            'placeholder' => '-',
                            'default_value' => null,
                            'tooltip' => null,
                            'unit' => null,
                            'hidden_label' => true,
                            'min_value' => 1,
                            'max_value' => 1000,
                            'step' => 1,
                            'input_mode' => 'numeric',
                        ],
                        'sort_order' => 1,
                    ],
                ]
            ],
            [
                'name' => 'wymiar_grafika',
                'label' => 'Wymiar grafika',
                'required' => false,
                'input_type' => AttributeInputType::ONLY_IMAGE,
                'input_variant' => AttributeInputVariant::NONE,
                'column_side' => AttributeSideColumn::COLUMN_RIGHT,
                'nr_step' => 3,
                'sort_order' => 1,
                'options' => [
                    [
                        'label' => 'wymiar grafika płaska',
                        'img' => [
                            'file' => 'attributes/prowadnica_plaska_pomiar.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'wymiar grafika przestrzenna',
                        'img' => [
                            'file' => 'attributes/prowadnica_przestrzenna_wymiar.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                ]
            ],
            [
                'name' => 'wymiar_opis',
                'label' => 'Wymiar opis',
                'required' => false,
                'input_type' => AttributeInputType::ONLY_TEXT,
                'input_variant' => AttributeInputVariant::NONE,
                'column_side' => AttributeSideColumn::COLUMN_RIGHT,
                'nr_step' => 3,
                'sort_order' => 2,
                'options' => [
                    [
                        'label' => 'Ograniczenia wymiarów płaska',
                        'config' => [
                            'description' => "<h3>OGRANICZENIA - kaseta płaska</h3>\r\n" .
                                "<p>Decydując się na roletę z prowadnicami płaskimi przy drzwiach balkonowych z ".
                                "poprzeczką muszą być zastosowane 2 rolety (dotyczy wszystkich tkanin).</p>" .
                                "<p>W wersji balkonowej rolety z kolekcji D&N w kolorze DN21 dostępne do wysokości ".
                                "190 cm. W wersji balkonowej rolety z kolekcji D&N premium dostępne do wysokości 200 cm</p>",
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Ograniczenia wymiarów przestrzenna',
                        'config' => [
                            'description' => "<h3>OGRANICZENIA - kaseta przestrzenna</h3>\r\n" .
                                "<p>W wersji balkonowej rolety z kolekcji D&N w kolorze DN21 dostępne do wysokości ".
                                "190 cm. W wersji balkonowej rolety z kolekcji D&N premium dostępne do wysokości 200 cm</p>",
                        ],
                        'sort_order' => 1,
                    ],
                ]
            ],
        ];
    }
}

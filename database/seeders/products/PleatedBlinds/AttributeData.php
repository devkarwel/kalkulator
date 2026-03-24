<?php

namespace Database\Seeders\products\PleatedBlinds;

use App\Enums\AttributeInputType;
use App\Enums\AttributeInputVariant;
use App\Enums\AttributeSideColumn;
use App\Enums\Unit;
use Illuminate\Support\Str;

class AttributeData
{
    public static function getDependency(): array
    {
        return [
            [
                'conditions' => [
                    ['attribute' => 'wybierz_rodzaj_montazu', 'value' => Str::slug(strtolower('MONTAŻ INWAZYJNY W ŚWIETLE SZYBY'), '_')],
                ],
                'then_show_attr' => 'wymiar_grafika',
                'show_values' => ['wymiar_grafika_inwazyjny'],
            ],
            [
                'conditions' => [
                    ['attribute' => 'wybierz_rodzaj_montazu', 'value' => 'montaz_bezinwazyjny_na_ramie_okiennej'],
                ],
                'then_show_attr' => 'wymiar_grafika',
                'show_values' => ['wymiar_grafika_bezinwazyjny'],
            ],
            [
                'conditions' => [
                    ['attribute' => 'wybierz_rodzaj_montazu', 'value' => Str::slug(strtolower('MONTAŻ INWAZYJNY W ŚWIETLE SZYBY'), '_')],
                ],
                'then_show_attr' => 'wymiar_opis',
                'show_values' => [
                    Str::slug(strtolower('Ograniczenia wymiarów inwazyjny'), '_')
                ],
            ],
            [
                'conditions' => [
                    ['attribute' => 'wybierz_rodzaj_montazu', 'value' => 'montaz_bezinwazyjny_na_ramie_okiennej'],
                ],
                'then_show_attr' => 'wymiar_opis',
                'show_values' => [
                    Str::slug(strtolower('Ograniczenia wymiarów bezinwazyjny'), '_')
                ],
            ],
            [
                'conditions' => [
                    ['attribute' => 'wybierz_rodzaj_montazu', 'value' => Str::slug(strtolower('MONTAŻ INWAZYJNY W ŚWIETLE SZYBY'), '_')],
                ],
                'then_show_attr' => 'wymiary',
                'show_values' => ['wymiar_u'],
            ],
        ];
    }

    public static function get(): array
    {
        return [
            [
                'name' => 'wybierz_rodzaj_montazu',
                'label' => 'Wybierz rodzaj montażu',
                'required' => true,
                'input_type' => AttributeInputType::SELECT_INPUT,
                'input_variant' => AttributeInputVariant::SELECT_IMAGE_ICON,
                'column_side' => AttributeSideColumn::COLUMN_LEFT,
                'nr_step' => 1,
                'sort_order' => 1,
                'options' => [
                    [
                        'label' => 'MONTAŻ INWAZYJNY W ŚWIETLE SZYBY',
                        'img' => [
                            'file' => 'attributes/montaz-inwazyjny.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'MONTAŻ BEZINWAZYJNY NA RAMIE OKIENNEJ',
                        'img' => [
                            'file' => 'attributes/montaz-bezinwazyjny.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 2,
                    ],
                ],
            ],
            [
                'name' => 'kolor_profilu_cosimo',
                'label' => 'KOLOR PROFILU COSIMO',
                'required' => true,
                'input_type' => AttributeInputType::SELECT_INPUT,
                'input_variant' => AttributeInputVariant::SELECT_IMAGE_SQUARE,
                'column_side' => AttributeSideColumn::COLUMN_RIGHT,
                'nr_step' => 1,
                'sort_order' => 1,
                'options' => [
                    [
                        'label' => 'Biały',
                        'img' => [
                            'file' => 'attributes/cosimo_bialy.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Złoty dąb',
                        'img' => [
                            'file' => 'attributes/cosimo_zlotydab.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 2,
                    ],
                    [
                        'label' => 'Orzech',
                        'img' => [
                            'file' => 'attributes/cosimo_orzech.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 3,
                    ],
                    [
                        'label' => 'Winchester',
                        'img' => [
                            'file' => 'attributes/cosimo_winchester.jpg',
                            'collection' => 'attribute',
                        ],
                        'config' => [
                            'has_extra_config' => true,
                            'tooltip' => 'UWAGA: OKUCIA PROFILU Winchester SĄ W KOLORZE brązowym'
                        ],
                        'sort_order' => 4,
                    ],
                    [
                        'label' => 'Antracyt',
                        'img' => [
                            'file' => 'attributes/cosimo_antracyt.jpg',
                            'collection' => 'attribute',
                        ],
                        'config' => [
                            'has_extra_config' => true,
                            'tooltip' => 'UWAGA: OKUCIA PROFILU ANTRACYT SĄ W KOLORZE CZARNYM'
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
                        'label' => 'Wymiar s',
                        'config' => [
                            'required' => true,
                            'label' => 'Szerokość (S)',
                            'placeholder' => '-',
                            'default_value' => null,
                            'tooltip' => 'Szerokość szyby mierzona wraz z uszczelkami',
                            'unit' => Unit::CM,
                            'min_value' => 0,
                            'max_value' => 120,
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Wymiar u',
                        'config' => [
                            'required' => true,
                            'label' => 'Wymiar (U)',
                            'placeholder' => '-',
                            'default_value' => null,
                            'tooltip' => 'Parametr na potrzeby produkcji',
                            'unit' => Unit::CM,
                            'min_value' => 0,
                            'max_value' => 120,
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Wymiar w',
                        'config' => [
                            'required' => true,
                            'label' => 'Wysokość (W)',
                            'placeholder' => '-',
                            'default_value' => null,
                            'tooltip' => 'Wysokość szyby mierzona wraz z uszczelkami',
                            'unit' => Unit::CM,
                            'min_value' => 0,
                            'max_value' => 220,
                        ],
                        'sort_order' => 2,
                    ],
                ]
            ],
            [
                'name' => 'ilosc',
                'label' => 'Ilość',
                'required' => true,
                'input_type' => AttributeInputType::FIELD_INPUT,
                'input_variant' => AttributeInputVariant::INPUT_NUMBER,
                'column_side' => AttributeSideColumn::COLUMN_LEFT,
                'nr_step' => 3,
                'sort_order' => 2,
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
                        'label' => 'wymiar grafika bezinwazyjny',
                        'img' => [
                            'file' => 'attributes/pomiar_bezinwazyjny.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'wymiar grafika inwazyjny',
                        'img' => [
                            'file' => 'attributes/pomiar_inwazyjny.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ]
                ],
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
                        'label' => 'Ograniczenia wymiarów bezinwazyjny',
                        'config' => [
                            'description' => "<h3>OGRANICZENIA (bezinwazyjne)</h3>\r\n" .
                                "<p>Maksymalna szerokość rolety wynosi 120 cm, powyżej tej szerokości rolety wykonywane są na ryzyko klienta</p>",
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Ograniczenia wymiarów inwazyjny',
                        'config' => [
                            'description' => "<h3>OGRANICZENIA (inwazyjne)</h3>\r\n" .
                                "<p>Maksymalna szerokość rolety wynosi 120 cm, powyżej tej szerokości rolety wykonywane są na ryzyko klienta</p>",
                        ],
                        'sort_order' => 1,
                    ],
                ]
            ],
        ];
    }
}

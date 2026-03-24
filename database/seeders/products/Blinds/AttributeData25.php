<?php

namespace Database\Seeders\products\Blinds;

use App\Enums\AttributeInputType;
use App\Enums\AttributeInputVariant;
use App\Enums\AttributeSideColumn;
use App\Enums\Unit;
use Illuminate\Support\Str;

class AttributeData25
{
    public static function getDependency(): array
    {
        return [
            // kolory lameli
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => 'zaluzje_drewniane_25_mm'],
                ],
                'then_show_attr' => 'kolor_lameli',
                'show_values' => [
                    'drewnianapure',
                    'bambusowa',
                ],
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => 'zaluzje_aluminiowe_25_mm'],
                ],
                'then_show_attr' => 'kolor_lameli',
                'show_values' => [
                    'standard_i_25mm',
                    'standard_ii_25mm'
                ],
            ],
            // kolory w lamelach
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => 'zaluzje_drewniane_25_mm'],
                    ['attribute' => 'kolor_lameli', 'value' => 'drewnianapure'],
                ],
                'then_show_attr' => 'kolory_do_wyboru',
                'show_values' => [
                    '2522', '2519', '2516', '2515', '2514',
                    '2513', '2512', '2511', '2510', '2521',
                    '2555', '2554', '2556', '2552', '2520'
                ]
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => 'zaluzje_drewniane_25_mm'],
                    ['attribute' => 'kolor_lameli', 'value' => 'bambusowa'],
                ],
                'then_show_attr' => 'kolory_do_wyboru',
                'show_values' => [
                    '2546', '2545', '2542', '2541', '2540',
                    '2547', '2568', '2567', '2566', '2565',
                    '2564', '2563', '2562', '2561'
                ]
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => 'zaluzje_aluminiowe_25_mm'],
                    ['attribute' => 'kolor_lameli', 'value' => ''],
                ],
                'then_show_attr' => 'kolory_do_wyboru',
                'show_values' => [
                ]
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => 'zaluzje_aluminiowe_25_mm'],
                    ['attribute' => 'kolor_lameli', 'value' => 'standard_i_25mm'],
                ],
                'then_show_attr' => 'kolory_do_wyboru',
                'show_values' => [
                    '158', '164', '169', '281', '423', '900', '168',
                ]
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => 'zaluzje_aluminiowe_25_mm'],
                    ['attribute' => 'kolor_lameli', 'value' => 'standard_ii_25mm'],
                ],
                'then_show_attr' => 'kolory_do_wyboru',
                'show_values' => [
                    '159', '165', '211', '511', '538',
                    '2000', '2005', '7016', '9006', '9007',
                    '43', '115', '179', '187', '212',
                    '517', '996', '117', '182', '191',
                    '475', '518', '3335', '172', '186',
                    '210', '509', '705', '3550', '772095',
                    '772098', '6042003',
                ]
            ],
            // montaz
            [
                'conditions' => [
                    ['attribute' => 'sposob_mocowania', 'value' => Str::slug(strtolower('MONTAŻ W ŚWIETLE SZYBY'), '_')],
                ],
                'then_show_attr' => 'rodzaj_mocowania',
                'show_values' => [
                    Str::slug(strtolower('MOCOWANIE RYNNY GÓRNEJ W ŚWIETLE SZYBY'), '_'),
                ],
            ],
            [
                'conditions' => [
                    ['attribute' => 'sposob_mocowania', 'value' => Str::slug(strtolower('MONTAŻ NA RAMIE OKIENNEJ'), '_')],
                ],
                'then_show_attr' => 'rodzaj_mocowania',
                'show_values' => [
                    Str::slug(strtolower('MOCOWANIE RYNNY GÓRNEJ NA RAMĘ OKIENNĄ'), '_'),
                    Str::slug(strtolower('MOCOWANIE BEZINWAZYJNE RYNNY GÓRNEJ'), '_'),
                ],
            ],
            // typ uhwytu
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_mocowania', 'value' => Str::slug(strtolower('MOCOWANIE RYNNY GÓRNEJ W ŚWIETLE SZYBY'), '_')],
                    ['attribute' => 'rodzaj_prowadzenia_bocznego', 'value' => 'zylka'],
                    ['attribute' => 'rodzaj_prowadzenia_bocznego', 'value' => 'linka_stalowa'],
                ],
                'then_show_attr' => 'typ_uchwytu_do_prowadzenia_bocznego',
                'show_values' => [
                    Str::slug(strtolower('WIESZAK DO PROWADZENIA BOCZNEGO W ŚWIETLE SZYBY'), '_'),
                ],
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_mocowania', 'value' => Str::slug(strtolower('MOCOWANIE RYNNY GÓRNEJ NA RAMĘ OKIENNĄ'), '_')],
                    ['attribute' => 'rodzaj_prowadzenia_bocznego', 'value' => 'zylka'],
                    ['attribute' => 'rodzaj_prowadzenia_bocznego', 'value' => 'linka_stalowa'],
                ],
                'then_show_attr' => 'typ_uchwytu_do_prowadzenia_bocznego',
                'show_values' => [
                    Str::slug(strtolower('WIESZAK KĄTOWY DO PROWADZENIA BOCZNEGO (TRANSPARENTNY)'), '_'),
                    Str::slug(strtolower('KĄTOWNIK Z TULEJKĄ (ALUMINIUM)'), '_'),
                ],
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_mocowania', 'value' => Str::slug(strtolower('MOCOWANIE BEZINWAZYJNE RYNNY GÓRNEJ'), '_')],
                    ['attribute' => 'rodzaj_prowadzenia_bocznego', 'value' => 'zylka'],
                    ['attribute' => 'rodzaj_prowadzenia_bocznego', 'value' => 'linka_stalowa'],
                ],
                'then_show_attr' => 'typ_uchwytu_do_prowadzenia_bocznego',
                'show_values' => [
                    Str::slug(strtolower('MOCOWANIE BEZINWAZYJNE DO PROWADZENIA BOCZNEGO'), '_'),
                ],
            ],
            // desc
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => Str::slug(strtolower('Żaluzje drewniane 25 mm'), '_')],
                ],
                'then_show_attr' => 'wymiar_opis',
                'show_values' => [Str::slug('Ograniczenia - żaluzje drewniane 25', '_')],
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => Str::slug(strtolower('Żaluzje aluminiowe 25 mm'), '_')],
                ],
                'then_show_attr' => 'wymiar_opis',
                'show_values' => [Str::slug('Ograniczenia - żaluzje aluminiowe 25', '_')],
            ],

            [
                'conditions' => [
                    ['attribute' => 'sposob_mocowania', 'value' => Str::slug(strtolower('MONTAŻ W ŚWIETLE SZYBY'), '_')],
                ],
                'then_show_attr' => 'wymiar_grafika',
                'show_values' => [Str::slug('wymiar światło szyby', '_')],
            ],
            [
                'conditions' => [
                    ['attribute' => 'sposob_mocowania', 'value' => Str::slug(strtolower('MONTAŻ NA RAMIE OKIENNEJ'), '_')],
                ],
                'then_show_attr' => 'wymiar_grafika',
                'show_values' => [Str::slug('wymiar rama okienna', '_')],
            ],
            // kolor kątownika
            [
                'conditions' => [
                    ['attribute' => 'typ_uchwytu_do_prowadzenia_bocznego', 'value' => Str::slug(strtolower('KĄTOWNIK Z TULEJKĄ (ALUMINIUM)'), '_')],
                ],
                'then_show_attr' => 'kolor_katownika',
                'show_all_values' => true,
            ],
            // kolor mocowania bezinwazyjnego
            [
                'conditions' => [
                    ['attribute' => 'typ_uchwytu_do_prowadzenia_bocznego', 'value' => Str::slug(strtolower('MOCOWANIE BEZINWAZYJNE DO PROWADZENIA BOCZNEGO'), '_')],
                ],
                'then_show_attr' => 'kolor_mocowania_bezinwazyjnego',
                'show_all_values' => true,
            ],
            // kolor mocowania bezinwazyjnego rynny
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_mocowania', 'value' => Str::slug(strtolower('MOCOWANIE BEZINWAZYJNE RYNNY GÓRNEJ'), '_')],
                ],
                'then_show_attr' => 'kolor_mocowania_bezinwazyjnego_rynny',
                'show_all_values' => true,
            ],
        ];
    }

    public static function get(): array
    {
        return [
            [
                'name' => 'rodzaj_zaluzji',
                'label' => 'Rodzaj żaluzji',
                'required' => true,
                'input_type' => AttributeInputType::SELECT_INPUT,
                'input_variant' => AttributeInputVariant::SELECT_IMAGE_ICON,
                'column_side' => AttributeSideColumn::COLUMN_LEFT,
                'nr_step' => 1,
                'sort_order' => 1,
                'options' => [
                    [
                        'label' => 'Żaluzje drewniane 25 mm',
                        'img' => [
                            'file' => 'attributes/zaluzje_drewniane_25mm.png',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Żaluzje aluminiowe 25 mm',
                        'img' => [
                            'file' => 'attributes/zaluzje_aluminiowe_25mm.png',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 2,
                    ],
                ],
            ],
            [
                'name' => 'kolor_lameli',
                'label' => 'Kolor lameli',
                'required' => true,
                'input_type' => AttributeInputType::SELECT_INPUT,
                'input_variant' => AttributeInputVariant::SELECT_IMAGE_CIRCLE,
                'column_side' => AttributeSideColumn::COLUMN_RIGHT,
                'nr_step' => 1,
                'sort_order' => 1,
                'options' => [
                    [
                        'label' => 'Drewniana/Pure',
                        'img' => [
                            'file' => 'attributes/lamele-drewniane-pure.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Bambusowa',
                        'img' => [
                            'file' => 'attributes/lamele-bambusowa.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 2,
                    ],
                    [
                        'label' => 'Standard I 25mm',
                        'img' => [
                            'file' => 'attributes/25_standard_i.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Standard II 25mm',
                        'img' => [
                            'file' => 'attributes/25_standard_ii.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 2,
                    ],
                ],
            ],
            [
                'name' => 'kolory_do_wyboru',
                'label' => 'Kolory do wyboru',
                'required' => true,
                'input_type' => AttributeInputType::SELECT_INPUT,
                'input_variant' => AttributeInputVariant::SELECT_IMAGE_SQUARE_SMALL,
                'column_side' => AttributeSideColumn::COLUMN_FULL,
                'nr_step' => 2,
                'sort_order' => 1,
                'options' => [
                    [
                        'label' => '2522',
                        'img' => [
                            'file' => 'attributes/2522.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2519',
                        'img' => [
                            'file' => 'attributes/2519.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2516',
                        'img' => [
                            'file' => 'attributes/2516.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2515',
                        'img' => [
                            'file' => 'attributes/2515.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2514',
                        'img' => [
                            'file' => 'attributes/2514.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2513',
                        'img' => [
                            'file' => 'attributes/2513.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2512',
                        'img' => [
                            'file' => 'attributes/2512.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2511',
                        'img' => [
                            'file' => 'attributes/2511.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2510',
                        'img' => [
                            'file' => 'attributes/2510.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2521',
                        'img' => [
                            'file' => 'attributes/2521.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2555',
                        'img' => [
                            'file' => 'attributes/2555.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2554',
                        'img' => [
                            'file' => 'attributes/2554.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2556',
                        'img' => [
                            'file' => 'attributes/2556.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2552',
                        'img' => [
                            'file' => 'attributes/2552.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2520',
                        'img' => [
                            'file' => 'attributes/2520.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],

                    [
                        'label' => '2546',
                        'img' => [
                            'file' => 'attributes/2546.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2545',
                        'img' => [
                            'file' => 'attributes/2545.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2542',
                        'img' => [
                            'file' => 'attributes/2542.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2541',
                        'img' => [
                            'file' => 'attributes/2541.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2540',
                        'img' => [
                            'file' => 'attributes/2540.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2547',
                        'img' => [
                            'file' => 'attributes/2547.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2568',
                        'img' => [
                            'file' => 'attributes/2568.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2567',
                        'img' => [
                            'file' => 'attributes/2567.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2566',
                        'img' => [
                            'file' => 'attributes/2566.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2565',
                        'img' => [
                            'file' => 'attributes/2565.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2564',
                        'img' => [
                            'file' => 'attributes/2564.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2563',
                        'img' => [
                            'file' => 'attributes/2563.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2562',
                        'img' => [
                            'file' => 'attributes/2562.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2561',
                        'img' => [
                            'file' => 'attributes/2561.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],

                    [
                        'label' => '158',
                        'img' => [
                            'file' => 'attributes/158.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '164',
                        'img' => [
                            'file' => 'attributes/164.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '169',
                        'img' => [
                            'file' => 'attributes/169.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '281',
                        'img' => [
                            'file' => 'attributes/281.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '423',
                        'img' => [
                            'file' => 'attributes/423.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '900',
                        'img' => [
                            'file' => 'attributes/900.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '168',
                        'img' => [
                            'file' => 'attributes/168.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],

                    [
                        'label' => '159',
                        'img' => [
                            'file' => 'attributes/159.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '165',
                        'img' => [
                            'file' => 'attributes/165.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '211',
                        'img' => [
                            'file' => 'attributes/211.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '511',
                        'img' => [
                            'file' => 'attributes/511.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '538',
                        'img' => [
                            'file' => 'attributes/538.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2000',
                        'img' => [
                            'file' => 'attributes/2000.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '2005',
                        'img' => [
                            'file' => 'attributes/2005.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '7016',
                        'img' => [
                            'file' => 'attributes/7016.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '9006',
                        'img' => [
                            'file' => 'attributes/9006.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '9007',
                        'img' => [
                            'file' => 'attributes/9007.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '43',
                        'img' => [
                            'file' => 'attributes/43.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '115',
                        'img' => [
                            'file' => 'attributes/115.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '179',
                        'img' => [
                            'file' => 'attributes/179.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '187',
                        'img' => [
                            'file' => 'attributes/187.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '212',
                        'img' => [
                            'file' => 'attributes/212.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '517',
                        'img' => [
                            'file' => 'attributes/517.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '996',
                        'img' => [
                            'file' => 'attributes/996.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '117',
                        'img' => [
                            'file' => 'attributes/117.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '182',
                        'img' => [
                            'file' => 'attributes/182.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '191',
                        'img' => [
                            'file' => 'attributes/191.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '475',
                        'img' => [
                            'file' => 'attributes/475.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '518',
                        'img' => [
                            'file' => 'attributes/518.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '3335',
                        'img' => [
                            'file' => 'attributes/3335.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '172',
                        'img' => [
                            'file' => 'attributes/172.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '186',
                        'img' => [
                            'file' => 'attributes/186.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '210',
                        'img' => [
                            'file' => 'attributes/210.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '509',
                        'img' => [
                            'file' => 'attributes/509.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '705',
                        'img' => [
                            'file' => 'attributes/705.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '3550',
                        'img' => [
                            'file' => 'attributes/3550.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '772095',
                        'img' => [
                            'file' => 'attributes/772095.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '772098',
                        'img' => [
                            'file' => 'attributes/772098.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '6042003',
                        'img' => [
                            'file' => 'attributes/6042003.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                ],
            ],
            [
                'label' => 'Sposób mocowania',
                'required' => true,
                'input_type' => AttributeInputType::SELECT_INPUT,
                'input_variant' => AttributeInputVariant::SELECT_IMAGE_ICON,
                'column_side' => AttributeSideColumn::COLUMN_LEFT,
                'nr_step' => 3,
                'sort_order' => 1,
                'options' => [
                    [
                        'label' => 'MONTAŻ W ŚWIETLE SZYBY',
                        'img' => [
                            'file' => 'attributes/montaz_w_swietle_szyby_25.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'MONTAŻ NA RAMIE OKIENNEJ',
                        'img' => [
                            'file' => 'attributes/montaz_na_ramie_okiennej_25.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 2,
                    ],
                ],
            ],
            [
                'label' => 'Rodzaj mocowania',
                'required' => true,
                'input_type' => AttributeInputType::SELECT_INPUT,
                'input_variant' => AttributeInputVariant::SELECT_IMAGE_RECTANGLE,
                'column_side' => AttributeSideColumn::COLUMN_LEFT,
                'nr_step' => 3,
                'sort_order' => 2,
                'options' => [
                    [
                        'label' => 'MOCOWANIE RYNNY GÓRNEJ NA RAMĘ OKIENNĄ',
                        'img' => [
                            'file' => 'attributes/MOCOWANIE RYNNY GÓRNEJ NA RAMĘ OKIENNĄ.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'MOCOWANIE RYNNY GÓRNEJ W ŚWIETLE SZYBY',
                        'img' => [
                            'file' => 'attributes/MOCOWANIE RYNNY GÓRNEJ W ŚWIETLE SZYBY.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 2,
                    ],
                    [
                        'label' => 'MOCOWANIE BEZINWAZYJNE RYNNY GÓRNEJ',
                        'img' => [
                            'file' => 'attributes/MOCOWANIE BEZINWAZYJNE RYNNY GÓRNEJ.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 3,
                    ],
                ],
            ],
            [
                'label' => 'Rodzaj prowadzenia bocznego',
                'required' => true,
                'input_type' => AttributeInputType::SELECT_INPUT,
                'input_variant' => AttributeInputVariant::SELECT_TEXT,
                'column_side' => AttributeSideColumn::COLUMN_RIGHT,
                'nr_step' => 3,
                'sort_order' => 1,
                'options' => [
                    [
                        'label' => 'Brak',
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Żyłka',
                        'sort_order' => 2,
                    ],
                    [
                        'label' => 'Linka stalowa',
                        'sort_order' => 3,
                    ],
                ],
            ],
            [
                'label' => 'Typ uchwytu do prowadzenia bocznego',
                'required' => false,
                'input_type' => AttributeInputType::SELECT_INPUT,
                'input_variant' => AttributeInputVariant::SELECT_IMAGE_RECTANGLE,
                'column_side' => AttributeSideColumn::COLUMN_RIGHT,
                'nr_step' => 3,
                'sort_order' => 2,
                'options' => [
                    [
                        'label' => 'KĄTOWNIK Z TULEJKĄ (ALUMINIUM)',
                        'img' => [
                            'file' => 'attributes/KĄTOWNIK Z TULEJKĄ (ALUMINIUM).jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'WIESZAK KĄTOWY DO PROWADZENIA BOCZNEGO (TRANSPARENTNY)',
                        'img' => [
                            'file' => 'attributes/WIESZAK KĄTOWY DO PROWADZENIA BOCZNEGO (TRANSPARENTNY).jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 2,
                    ],
                    [
                        'label' => 'WIESZAK DO PROWADZENIA BOCZNEGO W ŚWIETLE SZYBY',
                        'img' => [
                            'file' => 'attributes/WIESZAK DO PROWADZENIA BOCZNEGO W ŚWIETLE SZYBY.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 3,
                    ],
                    [
                        'label' => 'MOCOWANIE BEZINWAZYJNE DO PROWADZENIA BOCZNEGO',
                        'img' => [
                            'file' => 'attributes/MOCOWANIE BEZINWAZYJNE DO PROWADZENIA BOCZNEGO.jpg',
                            'collection' => 'attribute',
                        ],
                        'config' => [
                            'has_extra_config' => true,
                            'tooltip' => 'wybór koloru: biały, brąz, czarny',
                        ],
                        'sort_order' => 4,
                    ],
                ]
            ],
            [
                'name' => 'kolor_katownika',
                'label' => 'Kolor kątownika',
                'required' => true,
                'input_type' => AttributeInputType::SELECT_INPUT,
                'input_variant' => AttributeInputVariant::SELECT_TEXT,
                'column_side' => AttributeSideColumn::COLUMN_RIGHT,
                'nr_step' => 3,
                'sort_order' => 3,
                'options' => [
                    [
                        'label' => 'Biały',
                        'img' => [
                            'file' => 'attributes/kolor_bialy.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Brązowy',
                        'img' => [
                            'file' => 'attributes/kolor_brazowy.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 2,
                    ],
                ],
            ],
            [
                'name' => 'kolor_mocowania_bezinwazyjnego',
                'label' => 'Kolor mocowania bezinwazyjnego',
                'required' => true,
                'input_type' => AttributeInputType::SELECT_INPUT,
                'input_variant' => AttributeInputVariant::SELECT_IMAGE_CIRCLE,
                'column_side' => AttributeSideColumn::COLUMN_RIGHT,
                'nr_step' => 3,
                'sort_order' => 4,
                'options' => [
                    [
                        'label' => 'Biały',
                        'img' => [
                            'file' => 'attributes/kolor_bialy.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Brązowy',
                        'img' => [
                            'file' => 'attributes/kolor_brazowy.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 2,
                    ],
                    [
                        'label' => 'Czarny',
                        'img' => [
                            'file' => 'attributes/kolor_czarny.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 3,
                    ],
                ],
            ],
            [
                'name' => 'kolor_mocowania_bezinwazyjnego_rynny',
                'label' => 'Kolor mocowania bezinwazyjnego rynny',
                'required' => true,
                'input_type' => AttributeInputType::SELECT_INPUT,
                'input_variant' => AttributeInputVariant::SELECT_TEXT,
                'column_side' => AttributeSideColumn::COLUMN_RIGHT,
                'nr_step' => 3,
                'sort_order' => 5,
                'options' => [
                    [
                        'label' => 'Biały',
                        'img' => [
                            'file' => 'attributes/kolor_bialy.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Brązowy',
                        'img' => [
                            'file' => 'attributes/kolor_brazowy.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 2,
                    ],
                    [
                        'label' => 'Czarny',
                        'img' => [
                            'file' => 'attributes/kolor_czarny.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 3,
                    ],
                ],
            ],
            [
                'label' => 'Wymiary',
                'required' => true,
                'input_type' => AttributeInputType::FIELD_INPUT,
                'input_variant' => AttributeInputVariant::INPUT_NUMBER,
                'column_side' => AttributeSideColumn::COLUMN_LEFT,
                'nr_step' => 4,
                'sort_order' => 1,
                'options' => [
                    [
                        'label' => 'Wymiar A',
                        'config' => [
                            'required' => true,
                            'label' => 'Szerokość (A)',
                            'placeholder' => '-',
                            'default_value' => null,
                            'tooltip' => 'Szerokość szyby mierzona od uszczelki do uszczelki',
                            'unit' => Unit::CM,
                            'min_value' => 0,
                            'max_value' => 270,
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Wymiar B',
                        'config' => [
                            'required' => true,
                            'label' => 'Wysokość (B)',
                            'placeholder' => '-',
                            'default_value' => null,
                            'tooltip' => 'Wysokość szyby mierzona od uszczelki do uszczelki',
                            'unit' => Unit::CM,
                            'min_value' => 0,
                            'max_value' => 420,
                        ],
                        'sort_order' => 2,
                    ],
                ],
            ],
            [
                'name' => 'strona_sterowania',
                'label' => 'Strona sterowania',
                'required' => true,
                'input_type' => AttributeInputType::SELECT_INPUT,
                'input_variant' => AttributeInputVariant::SELECT_TEXT,
                'column_side' => AttributeSideColumn::COLUMN_LEFT,
                'nr_step' => 4,
                'sort_order' => 2,
                'options' => [
                    [
                        'label' => 'LL - obracanie z lewej, podnoszenie z lewej',
                        'img' => [
                            'file' => 'attributes/strona_sterowania_ll.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'LP - obracanie z lewej, podnoszenie z prawej',
                        'img' => [
                            'file' => 'attributes/strona_sterowania_lp.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 2,
                    ],
                    [
                        'label' => 'PL - obracanie z prawej, podnoszenie z lewej',
                        'img' => [
                            'file' => 'attributes/strona_sterowania_pl.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 3,
                    ],
                    [
                        'label' => 'PP - obracanie z prawej, podnoszenie z prawej',
                        'img' => [
                            'file' => 'attributes/strona_sterowania_pp.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 4,
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
                'nr_step' => 4,
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
                ],
            ],
            [
                'name' => 'wymiar_grafika',
                'label' => 'Wymiar grafika',
                'required' => false,
                'input_type' => AttributeInputType::ONLY_IMAGE,
                'input_variant' => AttributeInputVariant::NONE,
                'column_side' => AttributeSideColumn::COLUMN_RIGHT,
                'nr_step' => 4,
                'sort_order' => 1,
                'options' => [
                    [
                        'label' => 'wymiar światło szyby',
                        'img' => [
                            'file' => 'attributes/montaz_w_swietle_szyby_25.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'wymiar rama okienna',
                        'img' => [
                            'file' => 'attributes/montaz_na_ramie_okiennej_25.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                ],
            ],
            [
                'name' => 'wymiar_opis',
                'label' => 'Wymiar opis',
                'required' => false,
                'input_type' => AttributeInputType::ONLY_TEXT,
                'input_variant' => AttributeInputVariant::NONE,
                'column_side' => AttributeSideColumn::COLUMN_RIGHT,
                'nr_step' => 4,
                'sort_order' => 2,
                'options' => [
                    [
                        'label' => 'Ograniczenia - żaluzje drewniane 25',
                        'config' => [
                            'description' => "<h3>OGRANICZENIA</h3>\r\n" .
                                "<p>Żaluzja 25mm w światło szyby listwa musi wynosić co najmniej 1cm.</p>" .
                                "<p>Minimalna szerokosć dla żaluzji 25mm wynosi 40 cm.</p>".
                                "<p>Maksymalna szerokosć dla żaluzji drewnianej 25mm wynosi 270 cm, dla bambusowej 180 cm</p>" .
                                "<p>PRZED ZŁOŻENIEM ZAMÓWIENIA KLIENT MUSI UWZGLĘDNIĆ WYSOKOŚĆ NADPROŻA, KTÓRĄ ZAJMIE ZWINIĘTA ŻALUZJA WG SZKICU.</p>",
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Ograniczenia - żaluzje aluminiowe 25 ',
                        'config' => [
                            'description' => "<h3>OGRANICZENIA</h3>\r\n" .
                                "<p>Żaluzja 25mm w światło szyby listwa musi wynosić co najmniej 1cm.</p>" .
                                "<p>Minimalna szerokosć dla żaluzji 25mm wynosi 40 cm.</p>".
                                "<p>Maksymalna szerokosć dla żaluzji aluminiowej 25mm wynosi 290cm.</p>" .
                                "<p>PRZED ZŁOŻENIEM ZAMÓWIENIA KLIENT MUSI UWZGLĘDNIĆ WYSOKOŚĆ NADPROŻA, KTÓRĄ ZAJMIE ZWINIĘTA ŻALUZJA WG SZKICU.</p>",
                        ],
                        'sort_order' => 1,
                    ],
                ],
            ]
        ];
    }
}

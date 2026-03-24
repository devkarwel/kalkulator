<?php

namespace Database\Seeders\products\Blinds;

use App\Enums\AttributeInputType;
use App\Enums\AttributeInputVariant;
use App\Enums\AttributeSideColumn;
use App\Enums\Unit;
use Illuminate\Support\Str;

class AttributeData50
{
    public static function getDependency(): array
    {
        return [
            // kolory lameli
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => 'zaluzje_drewniane_50_mm'],
                ],
                'then_show_attr' => 'kolor_lameli',
                'show_values' => [
                    'drewnianapure',
                    'bambusowa',
                    'africashade',
                    'xs',
                ],
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => 'zaluzje_aluminiowe_50_mm'],
                ],
                'then_show_attr' => 'kolor_lameli',
                'show_values' => [
                    'standard_i',
                    'standard_ii',
                    'perforowana',
                ],
            ],
            // kolory w lamelach
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => 'zaluzje_drewniane_50_mm'],
                    ['attribute' => 'kolor_lameli', 'value' => 'drewnianapure'],
                ],
                'then_show_attr' => 'kolory_do_wyboru',
                'show_values' => [
                    '5022', '5019', '5016', '5015', '5014',
                    '5013', '5012', '5011', '5010', '5021',
                    '5055', '5053', '5054', '5056', '5052',
                    '5051', '5050', '5020'
                ]
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => 'zaluzje_drewniane_50_mm'],
                    ['attribute' => 'kolor_lameli', 'value' => 'bambusowa'],
                ],
                'then_show_attr' => 'kolory_do_wyboru',
                'show_values' => [
                    '5046', '5045', '5042', '5041', '5040',
                    '5047', '5068', '5067', '5066', '5065',
                    '5064', '5063', '5062', '5061'
                ]
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => 'zaluzje_drewniane_50_mm'],
                    ['attribute' => 'kolor_lameli', 'value' => 'africashade'],
                ],
                'then_show_attr' => 'kolory_do_wyboru',
                'show_values' => [
                    '5060', '5098', '5093', '5094', '5097',
                    '5091', '5096', '5095', '5092', '5080',
                    '5088', '5089', '5086', '5079', '5087',
                    '5083', '5082', '5081'
                ]
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => 'zaluzje_drewniane_50_mm'],
                    ['attribute' => 'kolor_lameli', 'value' => 'xs'],
                ],
                'then_show_attr' => 'kolory_do_wyboru',
                'show_values' => [
                    '50500', '50502', '50504', '50507', '50508',
                    '50509', '50510', '50511', '50512', '50513',
                    '50514', '50515', '50516', '50518', '50519',
                    '50523', '50520', '50521', '50552', '50554',
                    '50555', '50556'
                ]
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => 'zaluzje_aluminiowe_50_mm'],
                    ['attribute' => 'kolor_lameli', 'value' => 'standard_i'],
                ],
                'then_show_attr' => 'kolory_do_wyboru',
                'show_values' => [
                    '50100', '50110', '50120', '50130', '50140',
                    '50180', '50190', '50200', '50300', '50310',
                    '50320'
                ]
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => 'zaluzje_aluminiowe_50_mm'],
                    ['attribute' => 'kolor_lameli', 'value' => 'standard_ii'],
                ],
                'then_show_attr' => 'kolory_do_wyboru',
                'show_values' => [
                    '50220MAT', '50100MAT', '50150', '50160', '50170',
                    '50210', '50220'
                ]
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => 'zaluzje_aluminiowe_50_mm'],
                    ['attribute' => 'kolor_lameli', 'value' => 'perforowana'],
                ],
                'then_show_attr' => 'kolory_do_wyboru',
                'show_values' => [
                    '50220P', '50210P', '50200P', '50170P', '50160P',
                    '50150P', '50140P', '50120P', '50110P', '50100P'
                ]
            ],
            // kolory drabinek
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_drabinki', 'value' => 'drabinka_sznurkowa'],
                ],
                'then_show_attr' => Str::slug('Kolor drabinek - sznurkowe', '_'),
                'show_all_values' => true,
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_drabinki', 'value' => 'drabinka_tasmowa'],
                ],
                'then_show_attr' => Str::slug('Kolor drabinek - taśmowe', '_'),
                'show_all_values' => true,
            ],
            // maskownica - widoczna tylko dla kolekcji XS
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => 'zaluzje_drewniane_50_mm'],
                    ['attribute' => 'kolor_lameli', 'value' => 'xs'],
                ],
                'then_show_attr' => 'maskownica',
                'show_all_values' => true,
            ],
            // desc
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => Str::slug(strtolower('Żaluzje drewniane 50 mm'), '_')],
                ],
                'then_show_attr' => 'wymiar_opis',
                'show_values' => [Str::slug('Ograniczenia - żaluzje drewniane 50', '_')],
            ],
            [
                'conditions' => [
                    ['attribute' => 'rodzaj_zaluzji', 'value' => Str::slug(strtolower('Żaluzje aluminiowe 50 mm'), '_')],
                ],
                'then_show_attr' => 'wymiar_opis',
                'show_values' => [Str::slug('Ograniczenia - żaluzje aluminiowe 50', '_')],
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
                        'label' => 'Żaluzje drewniane 50 mm',
                        'img' => [
                            'file' => 'attributes/zaluzje_drewniane_50mm.png',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Żaluzje aluminiowe 50 mm',
                        'img' => [
                            'file' => 'attributes/zaluzje_aluminiowe_50mm.png',
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
                        'label' => 'Africa/Shade',
                        'img' => [
                            'file' => 'attributes/lamele-africa-shade.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 3,
                    ],
                    [
                        'label' => 'XS',
                        'img' => [
                            'file' => 'attributes/xs.jpg',
                            'collection' => 'attribute',
                        ],
                        'config' => [
                            'has_extra_config' => true,
                            'tooltip' => 'kolekcja XS uwzglednia drabinkę sznurkową oraz nie zawiera maskownicy górnej, opcja maskownicy dostępna za dopłatą 43zł/szt, opcja zamiany sznurka na taśmę za dopłatą 70zł/szt.',
                        ],
                        'sort_order' => 4,
                    ],
                    [
                        'label' => 'Standard I',
                        'img' => [
                            'file' => 'attributes/50_standard_i.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Standard II',
                        'img' => [
                            'file' => 'attributes/50_standard_ii.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 2,
                    ],
                    [
                        'label' => 'Perforowana',
                        'img' => [
                            'file' => 'attributes/perforowana.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 3,
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
                        'label' => '5022',
                        'img' => [
                            'file' => 'attributes/5022.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5019',
                        'img' => [
                            'file' => 'attributes/5019.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5016',
                        'img' => [
                            'file' => 'attributes/5016.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5015',
                        'img' => [
                            'file' => 'attributes/5015.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5014',
                        'img' => [
                            'file' => 'attributes/5014.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5013',
                        'img' => [
                            'file' => 'attributes/5013.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5012',
                        'img' => [
                            'file' => 'attributes/5012.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5011',
                        'img' => [
                            'file' => 'attributes/5011.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5010',
                        'img' => [
                            'file' => 'attributes/5010.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5021',
                        'img' => [
                            'file' => 'attributes/5021.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5055',
                        'img' => [
                            'file' => 'attributes/5055.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5053',
                        'img' => [
                            'file' => 'attributes/5053.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5054',
                        'img' => [
                            'file' => 'attributes/5054.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5056',
                        'img' => [
                            'file' => 'attributes/5056.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5052',
                        'img' => [
                            'file' => 'attributes/5052.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5051',
                        'img' => [
                            'file' => 'attributes/5051.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5050',
                        'img' => [
                            'file' => 'attributes/5050.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5020',
                        'img' => [
                            'file' => 'attributes/5020.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5046',
                        'img' => [
                            'file' => 'attributes/5046.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5045',
                        'img' => [
                            'file' => 'attributes/5045.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5042',
                        'img' => [
                            'file' => 'attributes/5042.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5041',
                        'img' => [
                            'file' => 'attributes/5041.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5040',
                        'img' => [
                            'file' => 'attributes/5040.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5047',
                        'img' => [
                            'file' => 'attributes/5047.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5068',
                        'img' => [
                            'file' => 'attributes/5068.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5067',
                        'img' => [
                            'file' => 'attributes/5067.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5066',
                        'img' => [
                            'file' => 'attributes/5066.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5065',
                        'img' => [
                            'file' => 'attributes/5065.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5064',
                        'img' => [
                            'file' => 'attributes/5064.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5063',
                        'img' => [
                            'file' => 'attributes/5063.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5062',
                        'img' => [
                            'file' => 'attributes/5062.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5061',
                        'img' => [
                            'file' => 'attributes/5061.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5060',
                        'img' => [
                            'file' => 'attributes/5060.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5098',
                        'img' => [
                            'file' => 'attributes/5098.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5093',
                        'img' => [
                            'file' => 'attributes/5093.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5094',
                        'img' => [
                            'file' => 'attributes/5094.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5097',
                        'img' => [
                            'file' => 'attributes/5097.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5091',
                        'img' => [
                            'file' => 'attributes/5091.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5096',
                        'img' => [
                            'file' => 'attributes/5096.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5095',
                        'img' => [
                            'file' => 'attributes/5095.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5092',
                        'img' => [
                            'file' => 'attributes/5092.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5080',
                        'img' => [
                            'file' => 'attributes/5080.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5088',
                        'img' => [
                            'file' => 'attributes/5088.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5089',
                        'img' => [
                            'file' => 'attributes/5089.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5086',
                        'img' => [
                            'file' => 'attributes/5086.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5079',
                        'img' => [
                            'file' => 'attributes/5079.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5087',
                        'img' => [
                            'file' => 'attributes/5087.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5083',
                        'img' => [
                            'file' => 'attributes/5083.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5082',
                        'img' => [
                            'file' => 'attributes/5082.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '5081',
                        'img' => [
                            'file' => 'attributes/5081.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],

                    [
                        'label' => '50500',
                        'img' => [
                            'file' => 'attributes/50500.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50502',
                        'img' => [
                            'file' => 'attributes/50502.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50504',
                        'img' => [
                            'file' => 'attributes/50504.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50507',
                        'img' => [
                            'file' => 'attributes/50507.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50508',
                        'img' => [
                            'file' => 'attributes/50508.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50509',
                        'img' => [
                            'file' => 'attributes/50509.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50510',
                        'img' => [
                            'file' => 'attributes/50510.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50511',
                        'img' => [
                            'file' => 'attributes/50511.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50512',
                        'img' => [
                            'file' => 'attributes/50512.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50513',
                        'img' => [
                            'file' => 'attributes/50513.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50514',
                        'img' => [
                            'file' => 'attributes/50514.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50515',
                        'img' => [
                            'file' => 'attributes/50515.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50516',
                        'img' => [
                            'file' => 'attributes/50516.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50518',
                        'img' => [
                            'file' => 'attributes/50518.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50519',
                        'img' => [
                            'file' => 'attributes/50519.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50523',
                        'img' => [
                            'file' => 'attributes/50523.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50520',
                        'img' => [
                            'file' => 'attributes/50520.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50521',
                        'img' => [
                            'file' => 'attributes/50521.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50552',
                        'img' => [
                            'file' => 'attributes/50552.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50554',
                        'img' => [
                            'file' => 'attributes/50554.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50555',
                        'img' => [
                            'file' => 'attributes/50555.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50556',
                        'img' => [
                            'file' => 'attributes/50556.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50100',
                        'img' => [
                            'file' => 'attributes/50100.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50110',
                        'img' => [
                            'file' => 'attributes/50110.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50120',
                        'img' => [
                            'file' => 'attributes/50120.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50130',
                        'img' => [
                            'file' => 'attributes/50130.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50140',
                        'img' => [
                            'file' => 'attributes/50140.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50180',
                        'img' => [
                            'file' => 'attributes/50180.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50190',
                        'img' => [
                            'file' => 'attributes/50190.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50200',
                        'img' => [
                            'file' => 'attributes/50200.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50300',
                        'img' => [
                            'file' => 'attributes/50300.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50310',
                        'img' => [
                            'file' => 'attributes/50310.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50320',
                        'img' => [
                            'file' => 'attributes/50320.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],

                    [
                        'label' => '50220MAT',
                        'img' => [
                            'file' => 'attributes/50220MAT.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50100MAT',
                        'img' => [
                            'file' => 'attributes/50100MAT.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50150',
                        'img' => [
                            'file' => 'attributes/50150.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50160',
                        'img' => [
                            'file' => 'attributes/50160.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50170',
                        'img' => [
                            'file' => 'attributes/50170.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50210',
                        'img' => [
                            'file' => 'attributes/50210.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50220',
                        'img' => [
                            'file' => 'attributes/50220.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],

                    [
                        'label' => '50220P',
                        'img' => [
                            'file' => 'attributes/50220P.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50210P',
                        'img' => [
                            'file' => 'attributes/50210P.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50200P',
                        'img' => [
                            'file' => 'attributes/50200P.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50170P',
                        'img' => [
                            'file' => 'attributes/50170P.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50160P',
                        'img' => [
                            'file' => 'attributes/50160P.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50150P',
                        'img' => [
                            'file' => 'attributes/50150P.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50140P',
                        'img' => [
                            'file' => 'attributes/50140P.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50120P',
                        'img' => [
                            'file' => 'attributes/50120P.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50110P',
                        'img' => [
                            'file' => 'attributes/50110P.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                    [
                        'label' => '50100P',
                        'img' => [
                            'file' => 'attributes/50100P.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 0,
                    ],
                ],
            ],
            [
                'label' => 'Rodzaj drabinki',
                'required' => true,
                'input_type' => AttributeInputType::SELECT_INPUT,
                'input_variant' => AttributeInputVariant::SELECT_TEXT,
                'column_side' => AttributeSideColumn::COLUMN_LEFT,
                'nr_step' => 3,
                'sort_order' => 1,
                'options' => [
                    [
                        'label' => 'Drabinka sznurkowa',
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Drabinka taśmowa',
                        'config' => [
                            'has_extra_config' => true,
                            'tooltip' => 'za dopłatą (aluminium: +5% ceny, drewniane: +70 zł/szt)',
                        ],
                        'sort_order' => 2,
                    ],
                ],
            ],
            [
                'name' => 'maskownica',
                'label' => 'Maskownica',
                'required' => true,
                'input_type' => AttributeInputType::SELECT_INPUT,
                'input_variant' => AttributeInputVariant::SELECT_TEXT,
                'column_side' => AttributeSideColumn::COLUMN_LEFT,
                'nr_step' => 3,
                'sort_order' => 2,
                'options' => [
                    [
                        'label' => 'Maskownica bez boczków',
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Maskownica z boczkami',
                        'config' => [
                            'has_extra_config' => true,
                            'tooltip' => 'za dopłatą 43 zł/szt',
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
                'column_side' => AttributeSideColumn::COLUMN_RIGHT,
                'nr_step' => 3,
                'sort_order' => 1,
                'options' => [
                    [
                        'label' => 'MOCOWANIE RYNNY GÓRNEJ - ŚCIANA',
                        'img' => [
                            'file' => 'attributes/MOCOWANIE RYNNY GÓRNEJ (ŚCIANA LUB SUFIT).jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'MOCOWANIE RYNNY GÓRNEJ - SUFIT',
                        'img' => [
                            'file' => 'attributes/MOCOWANIE RYNNY GÓRNEJ (ŚCIANA LUB SUFIT).jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 2,
                    ],
                ],
            ],
            [
                'label' => 'Kolor drabinek - sznurkowe',
                'required' => true,
                'input_type' => AttributeInputType::SELECT_INPUT,
                'input_variant' => AttributeInputVariant::SELECT_IMAGE_RECTANGLE,
                'column_side' => AttributeSideColumn::COLUMN_FULL,
                'nr_step' => 4,
                'sort_order' => 1,
                'options' => [
                    [
                        'label' => 'STANDARD',
                        'img' => [
                            'file' => 'collections/drabinki/sznurkowe/STANDARD.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'ALABASTER',
                        'img' => [
                            'file' => 'collections/drabinki/sznurkowe/ALABASTER.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'BEIGE',
                        'img' => [
                            'file' => 'collections/drabinki/sznurkowe/BEIGE.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 2,
                    ],
                    [
                        'label' => 'BLACK',
                        'img' => [
                            'file' => 'collections/drabinki/sznurkowe/BLACK.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 3,
                    ],
                    [
                        'label' => 'CACAO',
                        'img' => [
                            'file' => 'collections/drabinki/sznurkowe/CACAO.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 4,
                    ],
                    [
                        'label' => 'CORDOVAN',
                        'img' => [
                            'file' => 'collections/drabinki/sznurkowe/CORDOVAN.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 5,
                    ],
                    [
                        'label' => 'DARK BEIGE',
                        'img' => [
                            'file' => 'collections/drabinki/sznurkowe/DARK BEIGE.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 6,
                    ],
                    [
                        'label' => 'GREY',
                        'img' => [
                            'file' => 'collections/drabinki/sznurkowe/GREY.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 7,
                    ],
                    [
                        'label' => 'IVORY',
                        'img' => [
                            'file' => 'collections/drabinki/sznurkowe/IVORY.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 8,
                    ],
                    [
                        'label' => 'MOCCA',
                        'img' => [
                            'file' => 'collections/drabinki/sznurkowe/MOCCA.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 9,
                    ],
                    [
                        'label' => 'WALNUT',
                        'img' => [
                            'file' => 'collections/drabinki/sznurkowe/WALNUT.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 10,
                    ],
                    [
                        'label' => 'WHITE',
                        'img' => [
                            'file' => 'collections/drabinki/sznurkowe/WHITE.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 11,
                    ],
                ],
            ],
            [
                'label' => 'Kolor drabinek - taśmowe',
                'required' => true,
                'input_type' => AttributeInputType::SELECT_INPUT,
                'input_variant' => AttributeInputVariant::SELECT_IMAGE_RECTANGLE,
                'column_side' => AttributeSideColumn::COLUMN_FULL,
                'nr_step' => 4,
                'sort_order' => 1,
                'options' => [
                    [
                        'label' => 'STANDARD',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/STANDARD.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'WHITE',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/WHITE.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'LIGHT CREAM',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/LIGHT CREAM.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 2,
                    ],
                    [
                        'label' => 'BEIGE',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/BEIGE.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 3,
                    ],
                    [
                        'label' => 'BLEACHED SAND',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/BLEACHED SAND.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 4,
                    ],
                    [
                        'label' => 'OYSTER',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/OYSTER.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 5,
                    ],
                    [
                        'label' => 'STONE',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/STONE.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 6,
                    ],
                    [
                        'label' => 'COVENTY GREY',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/COVENTY GREY.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 7,
                    ],
                    [
                        'label' => 'GINGER',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/GINGER.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 8,
                    ],
                    [
                        'label' => 'DARK BEIGE',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/DARK BEIGE.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 9,
                    ],
                    [
                        'label' => 'WALNUT',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/WALNUT.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 10,
                    ],
                    [
                        'label' => 'CACAO',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/CACAO.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 11,
                    ],
                    [
                        'label' => 'DARK KHAKI',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/DARK KHAKI.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 12,
                    ],
                    [
                        'label' => 'METAL',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/METAL.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 13,
                    ],
                    [
                        'label' => 'LIMESTONE',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/LIMESTONE.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 14,
                    ],
                    [
                        'label' => 'GREY',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/GREY.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 15,
                    ],
                    [
                        'label' => 'ANTHRACITE',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/ANTHRACITE.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 16,
                    ],
                    [
                        'label' => 'BLACK',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/BLACK.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 17,
                    ],
                    [
                        'label' => 'MOCCA',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/MOCCA.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 18,
                    ],
                    [
                        'label' => 'COPPER',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/COPPER.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 19,
                    ],
                    [
                        'label' => 'TERRA',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/TERRA.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 20,
                    ],
                    [
                        'label' => 'CORDOVAN',
                        'img' => [
                            'file' => 'collections/drabinki/tasmowe/CORDOVAN.jpg',
                            'collection' => 'attribute',
                        ],
                        'sort_order' => 21,
                    ],
                ],
            ],
            [
                'label' => 'Wymiary',
                'required' => true,
                'input_type' => AttributeInputType::FIELD_INPUT,
                'input_variant' => AttributeInputVariant::INPUT_NUMBER,
                'column_side' => AttributeSideColumn::COLUMN_LEFT,
                'nr_step' => 5,
                'sort_order' => 1,
                'options' => [
                    [
                        'label' => 'Wymiar A',
                        'config' => [
                            'required' => true,
                            'label' => 'Szerokość (A)',
                            'placeholder' => '-',
                            'default_value' => null,
                            'tooltip' => null,
                            'unit' => Unit::CM,
                            'min_value' => 40,
                            'max_value' => 500,
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Wymiar b',
                        'config' => [
                            'required' => true,
                            'label' => 'Wysokość (B)',
                            'placeholder' => '-',
                            'default_value' => null,
                            'tooltip' => null,
                            'unit' => Unit::CM,
                            'min_value' => 40,
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
                'nr_step' => 5,
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
                'nr_step' => 5,
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
                'nr_step' => 5,
                'sort_order' => 1,
                'options' => [
                    [
                        'label' => 'wymiar grafika żaluzje',
                        'img' => [
                            'file' => 'attributes/wymiar_grafika.jpg',
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
                'nr_step' => 5,
                'sort_order' => 2,
                'options' => [
                    [
                        'label' => 'Ograniczenia - żaluzje drewniane 50',
                        'config' => [
                            'description' => "<h3>OGRANICZENIA</h3>\r\n" .
                                "<p>Kolekcja XS maskownica w standardzie bez boczków i z drabinką sznurkową – za dopłatą drabinka taśmowa i maskownica z boczkami.</p>" .
                                "<p>Żaluzja poniżej 50cm sterowanie jest podzielone na prawa-lewa</p>" .
                                "<p>Minimalna szerokosć dla żaluzji drewnianej 50mm wynosi 60 cm. Maksymalna szerokosć dla żaluzji bambusowej 180 cm" .
                                "dla drewnianej 50mm wynosi 270cm, dla bambusowej wynosi 240 cm</p>" .
                                "<p>PRZED ZŁOŻENIEM ZAMÓWIENIA KLIENT MUSI UWZGLĘDNIĆ WYSOKOŚĆ NADPROŻA, KTÓRĄ ZAJMIE ZWINIĘTA ŻALUZJA WG SZKICU</p>",
                        ],
                        'sort_order' => 1,
                    ],
                    [
                        'label' => 'Ograniczenia - żaluzje aluminiowe 50',
                        'config' => [
                            'description' => "<h3>OGRANICZENIA</h3>\r\n" .
                                "<p>Żaluzja aluminiowa 50mm standard tylko drabinka sznurkowa – taśmowa za dopłatą</p>" .
                                "<p>Żaluzja poniżej 50cm sterowanie jest podzielone na prawa-lewa</p>" .
                                "<p>Minimalna szerokosć dla aluminiowej 50 wynosi 40 cm.</p>".
                                "<p>Maksymalna szerokosć dla żaluzji aluminiowej 50mm wyniosi 500cm.</p>" .
                                "<p>PRZED ZŁOŻENIEM ZAMÓWIENIA KLIENT MUSI UWZGLĘDNIĆ WYSOKOŚĆ NADPROŻA, KTÓRĄ ZAJMIE ZWINIĘTA ŻALUZJA WG SZKICU</p>",
                        ],
                        'sort_order' => 1,
                    ],
                ],
            ]
        ];
    }
}

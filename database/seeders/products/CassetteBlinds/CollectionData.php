<?php

namespace Database\Seeders\products\CassetteBlinds;

use App\Enums\AttributeInputType;
use App\Enums\AttributeInputVariant;
use App\Enums\AttributeSideColumn;

final class CollectionData
{
    public static function get(): array
    {
        return [
            [
                'label' => 'Kolekcja rolet w kasecie',
                'attribute' => [
                    'label' => 'Kolekcja rolet',
                    'input_type' => AttributeInputType::COLLECTION,
                    'input_variant' => AttributeInputVariant::SELECT_IMAGE_SQUARE,
                    'column_side' => AttributeSideColumn::COLUMN_FULL,
                    'nr_step' => 2,
                ],
                'items' => [
                    [
                        'name' => 'DZIEŃ NOC 01-09',
                        'cover_img' => 'dn/dn.jpg',
                        'dir' => 'dn',
                        'items' => [
                            [
                                'name' => 'DN01',
                                'img' => 'dn/DN01.jpg',
                            ],
                            [
                                'name' => 'DN02',
                                'img' => 'dn/DN02.jpg',
                            ],
                            [
                                'name' => 'DN03',
                                'img' => 'dn/DN03.jpg',
                            ],
                            [
                                'name' => 'DN04',
                                'img' => 'dn/DN04.jpg',
                            ],
                            [
                                'name' => 'DN05',
                                'img' => 'dn/DN05.jpg',
                            ],
                            [
                                'name' => 'DN06',
                                'img' => 'dn/DN06.jpg',
                            ],
                            [
                                'name' => 'DN07',
                                'img' => 'dn/DN07.jpg',
                            ],
                            [
                                'name' => 'DN08',
                                'img' => 'dn/DN08.jpg',
                            ],
                            [
                                'name' => 'DN09',
                                'img' => 'dn/DN09.jpg',
                            ],
                        ],
                    ],
                    [
                        'name' => 'DZIEŃ NOC 21-27',
                        'cover_img' => 'dn/dn.jpg',
                        'dir' => 'dn',
                        'items' => [
                            [
                                'name' => 'DN21',
                                'img' => 'dn/DN21.jpg',
                            ],
                            [
                                'name' => 'DN22',
                                'img' => 'dn/DN22.jpg',
                            ],
                            [
                                'name' => 'DN23',
                                'img' => 'dn/DN23.jpg',
                            ],
                            [
                                'name' => 'DN24',
                                'img' => 'dn/DN24.jpg',
                            ],
                            [
                                'name' => 'DN25',
                                'img' => 'dn/DN25.jpg',
                            ],
                            [
                                'name' => 'DN26',
                                'img' => 'dn/DN26.jpg',
                            ],
                            [
                                'name' => 'DN27',
                                'img' => 'dn/DN27.jpg',
                            ],
                        ],
                    ],
                    [
                        'name' => 'Dzień noc 31-37',
                        'cover_img' => 'dn/dn.jpg',
                        'dir' => 'dn',
                        'items' => [
                            [
                                'name' => 'DN31',
                                'img' => 'dn/DN31.jpg',
                            ],
                            [
                                'name' => 'DN32',
                                'img' => 'dn/DN32.jpg',
                            ],
                            [
                                'name' => 'DN33',
                                'img' => 'dn/DN33.jpg',
                            ],
                            [
                                'name' => 'DN34',
                                'img' => 'dn/DN34.jpg',
                            ],
                            [
                                'name' => 'DN35',
                                'img' => 'dn/DN35.jpg',
                            ],
                            [
                                'name' => 'DN36',
                                'img' => 'dn/DN36.jpg',
                            ],
                            [
                                'name' => 'DN37',
                                'img' => 'dn/DN37.jpg',
                            ],
                        ]
                    ],
                    [
                        'name' => 'DZIEŃ NOC PREMIUM DNP1-DNP6',
                        'cover_img' => 'dnp/dn-premium.jpg',
                        'dir' => 'dnp',
                        'items' => [
                            [
                                'name' => 'DNP1',
                                'img' => 'dnp/DNP1.jpg',
                            ],
                            [
                                'name' => 'DNP2',
                                'img' => 'dnp/dnp2.jpg',
                            ],
                            [
                                'name' => 'DNP3',
                                'img' => 'dnp/DNP3.jpg',
                            ],
                            [
                                'name' => 'DNP4',
                                'img' => 'dnp/DNP4.jpg',
                            ],
                            [
                                'name' => 'DNP5',
                                'img' => 'dnp/DNP5.jpg',
                            ],
                            [
                                'name' => 'DNP6',
                                'img' => 'dnp/DNP6.jpg',
                            ],
                        ],
                    ],
                    [
                        'name' => 'MEDIUM',
                        'cover_img' => 'medium/medium.jpg',
                        'dir' => 'medium',
                        'items' => [
                            [
                                'name' => 'MD01',
                                'img' => 'medium/MD01.jpg',
                            ],
                            [
                                'name' => 'MD02',
                                'img' => 'medium/MD02.jpg',
                            ],
                            [
                                'name' => 'MD03',
                                'img' => 'medium/MD03.jpg',
                            ],
                            [
                                'name' => 'MD04',
                                'img' => 'medium/MD04.jpg',
                            ],
                            [
                                'name' => 'MD05',
                                'img' => 'medium/MD05.jpg',
                            ],
                            [
                                'name' => 'MD06',
                                'img' => 'medium/MD06.jpg',
                            ],
                        ],
                    ],
                    [
                        'name' => 'OPTIMA',
                        'cover_img' => 'optima/optima.jpg',
                        'dir' => 'optima',
                        'items' => [
                            [
                                'name' => 'OP01',
                                'img' => 'optima/1.jpg',
                            ],
                            [
                                'name' => 'OP02',
                                'img' => 'optima/2.jpg',
                            ],
                            [
                                'name' => 'OP03',
                                'img' => 'optima/3.jpg',
                            ],
                            [
                                'name' => 'OP04',
                                'img' => 'optima/4.jpg',
                            ],
                            [
                                'name' => 'OP05',
                                'img' => 'optima/5.jpg',
                            ],
                            [
                                'name' => 'OP06',
                                'img' => 'optima/6.jpg',
                            ],
                            [
                                'name' => 'OP07',
                                'img' => 'optima/7.jpg',
                            ],
                            [
                                'name' => 'OP08',
                                'img' => 'optima/8.jpg',
                            ],
                            [
                                'name' => 'OP09',
                                'img' => 'optima/9.jpg',
                            ],
                            [
                                'name' => 'OP10',
                                'img' => 'optima/10.jpg',
                            ],
                            [
                                'name' => 'OP11',
                                'img' => 'optima/11.jpg',
                            ],
                            [
                                'name' => 'OP12',
                                'img' => 'optima/12.jpg',
                            ],
                            [
                                'name' => 'OP13',
                                'img' => 'optima/13.jpg',
                            ],
                            [
                                'name' => 'OP14',
                                'img' => 'optima/14.jpg',
                            ],
                            [
                                'name' => 'OP15',
                                'img' => 'optima/15.jpg',
                            ],
                            [
                                'name' => 'OP16',
                                'img' => 'optima/16.jpg',
                            ],
                            [
                                'name' => '17',
                                'img' => 'optima/17.jpg',
                            ],
                            [
                                'name' => 'OP18',
                                'img' => 'optima/18.jpg',
                            ],
                            [
                                'name' => 'OP19',
                                'img' => 'optima/19.jpg',
                            ],
                        ],
                    ],
                    [
                        'name' => 'K800',
                        'cover_img' => 'k800/k800.jpg',
                        'dir' => 'k800',
                        'items' => [
                            [
                                'name' => 'K804',
                                'img' => 'k800/804.jpg',
                            ],
                            [
                                'name' => 'K805',
                                'img' => 'k800/805.jpg',
                            ],
                            [
                                'name' => 'K806',
                                'img' => 'k800/806.jpg',
                            ],
                            [
                                'name' => 'K807',
                                'img' => 'k800/807.jpg',
                            ],
                            [
                                'name' => 'K808',
                                'img' => 'k800/808.jpg',
                            ],
                            [
                                'name' => 'K811',
                                'img' => 'k800/811.jpg',
                            ],
                            [
                                'name' => 'K813',
                                'img' => 'k800/813.jpg',
                            ],
                            [
                                'name' => 'K816',
                                'img' => 'k800/816.jpg',
                            ],
                            [
                                'name' => 'K817',
                                'img' => 'k800/817.jpg',
                            ],
                            [
                                'name' => 'K818',
                                'img' => 'k800/818.jpg',
                            ],
                            [
                                'name' => 'K821',
                                'img' => 'k800/821.jpg',
                            ],
                            [
                                'name' => 'K822',
                                'img' => 'k800/822.jpg',
                            ],
                            [
                                'name' => 'K825',
                                'img' => 'k800/825.jpg',
                            ],
                            [
                                'name' => 'K826',
                                'img' => 'k800/826.jpg',
                            ],
                            [
                                'name' => 'K827',
                                'img' => 'k800/827.jpg',
                            ],
                            [
                                'name' => 'K831',
                                'img' => 'k800/831.jpg',
                            ],
                            [
                                'name' => 'K834',
                                'img' => 'k800/834.jpg',
                            ],
                            [
                                'name' => 'K835',
                                'img' => 'k800/835.jpg',
                            ],
                            [
                                'name' => 'K801',
                                'img' => 'k800/K801.jpg',
                            ],
                            [
                                'name' => 'K802',
                                'img' => 'k800/K802.jpg',
                            ],
                            [
                                'name' => 'K803',
                                'img' => 'k800/K803.jpg',
                            ],
                            [
                                'name' => 'K809',
                                'img' => 'k800/K809.jpg',
                            ],
                        ],
                    ],
                    [
                        'name' => 'B500',
                        'cover_img' => 'b500/b500.jpg',
                        'dir' => 'b500',
                        'items' => [
                            [
                                'name' => 'B501',
                                'img' => 'b500/501.jpg',
                            ],
                            [
                                'name' => 'B502',
                                'img' => 'b500/502.jpg',
                            ],
                            [
                                'name' => 'B503',
                                'img' => 'b500/503.jpg',
                            ],
                            [
                                'name' => 'B504',
                                'img' => 'b500/504.jpg',
                            ],
                            [
                                'name' => 'B505',
                                'img' => 'b500/505.jpg',
                            ],
                            [
                                'name' => 'B506',
                                'img' => 'b500/506.jpg',
                            ],
                            [
                                'name' => 'B507',
                                'img' => 'b500/507.jpg',
                            ],
                            [
                                'name' => 'B508',
                                'img' => 'b500/508.jpg',
                            ],
                            [
                                'name' => 'B509',
                                'img' => 'b500/509.jpg',
                            ],
                        ],
                    ],
                    [
                        'name' => 'ORIENTAL',
                        'cover_img' => 'oriental/oriental.jpg',
                        'dir' => 'oriental',
                        'items' => [
                            [
                                'name' => 'OR01',
                                'img' => 'oriental/OR01.jpg',
                            ],
                            [
                                'name' => 'OR02',
                                'img' => 'oriental/OR02.jpg',
                            ],
                            [
                                'name' => 'OR03',
                                'img' => 'oriental/OR03.jpg',
                            ],
                            [
                                'name' => 'OR04',
                                'img' => 'oriental/OR04.jpg',
                            ],
                            [
                                'name' => 'OR05',
                                'img' => 'oriental/OR05.jpg',
                            ],
                        ],
                    ],
                    [
                        'name' => 'TERMO',
                        'cover_img' => 'termo/termo.jpg',
                        'dir' => 'termo',
                        'items' => [
                            [
                                'name' => 'BT01',
                                'img' => 'termo/BT01.jpg',
                            ],
                            [
                                'name' => 'BT02',
                                'img' => 'termo/BT02.jpg',
                            ],
                            [
                                'name' => 'BT03',
                                'img' => 'termo/BT03.jpg',
                            ],
                            [
                                'name' => 'BT04',
                                'img' => 'termo/BT04.jpg',
                            ],
                            [
                                'name' => 'BT05',
                                'img' => 'termo/BT05.jpg',
                            ],
                            [
                                'name' => 'BT06',
                                'img' => 'termo/BT06.jpg',
                            ],
                        ],
                    ],
                ]
            ]
        ];
    }
}

<?php

namespace Database\Seeders\products\CassetteBlinds;

use App\Enums\PriceActionModifier;
use App\Enums\PriceTypeModifier;

class PriceListData
{
    public static function get(): array
    {
        return [
            [
                'name' => 'Cennik - DN 01-09 biała PCV',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'dzien_noc_01_09',
                        ]
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'bialy_pcv',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 96.56],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 107.68],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 118.80],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 129.03],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 138.66],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 149.14],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 160.01],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 169.76],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 180.51],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 190.73],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 202.10],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 109.17],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 121.93],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 134.79],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 145.39],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 159.27],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 172.39],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 184.25],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 198.23],
                ],
            ],
            [
                'name' => 'Cennik - DN 01-09 biała ALU',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'dzien_noc_01_09',
                        ],
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'bialy_aluminium',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 104.80],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 118.92],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 139.52],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 152.13],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 168.76],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 187.25],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 201.86],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 218.85],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 235.83],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 252.45],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 268.81],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 139.52],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 159.39],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 179.26],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 202.24],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 225.23],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 249.45],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 272.57],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 292.79],
                ],
            ],
            [
                'name' => 'Cennik - DN 01-09 kolor ALU',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'dzien_noc_01_09'
                        ],
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'orzech_aluminium',
                            'dab_jasny_aluminium',
                            'dab_ciemny_aluminium',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 131.01],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 148.65],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 174.42],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 190.19],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 210.97],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 234.07],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 252.33],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 273.57],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 294.79],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 315.57],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 336.01],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 174.42],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 199.24],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 224.07],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 252.80],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 281.54],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 311.83],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 340.70],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 366.00],
                ],
            ],
            [
                'name' => 'Cennik - DN 21-27 biała PCV',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'dzien_noc_21_27',
                        ]
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'bialy_pcv',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 112.69],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 125.17],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 144.28],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 158.27],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 174.26],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 188.87],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 204.11],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 219.84],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 234.58],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 251.33],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 266.94],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 123.28],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 146.78],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 169.27],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 184.61],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 200.61],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 217.84],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 235.83],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 257.32],
                ],
            ],
            [
                'name' => 'Cennik - DN 21-27 biała ALU',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'dzien_noc_21_27',
                        ]
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'bialy_aluminium',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 124.41],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 146.41],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 165.75],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 191.61],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 211.35],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 231.09],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 249.83],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 270.30],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 290.56],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 310.42],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 329.89],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 151.03],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 167.63],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 192.26],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 218.85],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 246.20],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 272.19],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 299.41],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 324.78],
                ],
            ],
            [
                'name' => 'Cennik - DN 21-27 kolor ALU',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'dzien_noc_21_27',
                        ]
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'orzech_aluminium',
                            'dab_jasny_aluminium',
                            'dab_ciemny_aluminium',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 155.53],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 183.02],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 207.21],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 239.53],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 264.19],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 288.87],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 312.29],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 337.90],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 363.17],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 388.03],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 412.37],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 188.77],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 209.54],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 240.31],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 273.57],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 307.77],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 340.24],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 374.28],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 405.97],
                ]
            ],
            [
                'name' => 'Cennik - DN 31-37 biała PCV',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'dzien_noc_31_37',
                        ]
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'bialy_pcv',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 112.67],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 125.16],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 144.27],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 158.27],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 174.25],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 188.87],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 204.11],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 219.85],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 234.59],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 251.33],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 266.94],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 123.29],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 146.77],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 169.26],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 184.62],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 200.61],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 217.85],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 235.84],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 257.32],
                ],
            ],
            [
                'name' => 'Cennik - DN 31-37 biała ALU',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'dzien_noc_31_37',
                        ]
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'bialy_aluminium',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 124.41],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 146.40],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 165.76],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 191.62],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 211.35],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 231.09],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 249.83],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 270.31],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 290.55],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 310.41],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 329.90],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 151.02],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 167.63],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 192.24],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 218.85],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 246.20],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 272.19],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 299.42],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 324.77],
                ],
            ],
            [
                'name' => 'Cennik - DN 31-37 kolor ALU',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'dzien_noc_31_37',
                        ]
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'orzech_aluminium',
                            'dab_jasny_aluminium',
                            'dab_ciemny_aluminium',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 155.53],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 183.02],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 207.21],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 239.53],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 264.19],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 288.87],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 312.29],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 337.90],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 363.17],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 388.03],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 412.37],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 188.77],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 209.54],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 240.31],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 273.57],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 307.77],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 340.24],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 374.28],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 405.97],
                ],
            ],
            [
                'name' => 'Cennik - DNP biała PCV',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'dzien_noc_premium_dnp1_dnp6',
                        ]
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'bialy_pcv',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 132.28],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 152.02],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 175.13],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 196.49],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 214.23],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 233.47],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 252.82],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 273.68],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 292.68],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 313.28],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 334.39],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 150.39],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 175.00],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 202.10],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 226.73],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 251.82],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 274.19],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 297.30],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 317.53],
                ],
            ],
            [
                'name' => 'Cennik - DNP biała ALU',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'dzien_noc_premium_dnp1_dnp6',
                        ]
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'bialy_aluminium',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 149.65],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 176.51],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 203.98],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 229.59],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 256.57],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 282.67],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 309.04],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 335.52],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 361.25],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 386.73],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 413.96],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 163.52],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 196.49],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 232.34],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 266.45],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 300.92],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 336.40],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 371.87],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 410.21],
                ],
            ],
            [
                'name' => 'Cennik - DNP kolor ALU',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'dzien_noc_premium_dnp1_dnp6',
                        ]
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'orzech_aluminium',
                            'dab_jasny_aluminium',
                            'dab_ciemny_aluminium',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 187.06],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 220.64],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 254.98],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 286.99],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 320.71],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 353.36],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 386.31],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 419.39],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 451.57],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 483.41],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 517.45],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 204.40],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 245.63],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 290.43],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 333.06],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 376.15],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 420.50],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 464.84],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 512.78],
                ],
            ],
            [
                'name' => 'Cennik - K800 biała PCV',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'k800',
                        ]
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'bialy_pcv',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 78.32],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 84.57],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 90.44],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 96.94],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 102.18],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 109.56],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 114.30],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 122.04],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 130.03],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 137.67],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 143.54],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 96.81],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 100.81],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 106.93],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 113.05],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 118.66],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 125.17],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 130.54],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 136.04],
                ],
            ],
            [
                'name' => 'Cennik - K800 biała ALU',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'k800',
                        ]
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'bialy_aluminium',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 103.41],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 108.68],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 114.43],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 122.04],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 127.79],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 133.40],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 140.41],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 145.28],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 152.39],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 158.64],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 165.75],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 133.65],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 136.53],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 140.16],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 143.40],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 146.91],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 149.40],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 153.03],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 157.14],
                ],
            ],
            [
                'name' => 'Cennik - K800 kolor ALU',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'k800',
                        ]
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'orzech_aluminium',
                            'dab_jasny_aluminium',
                            'dab_ciemny_aluminium',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 134.45],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 141.27],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 148.74],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 158.66],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 166.12],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 173.44],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 182.52],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 188.86],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 198.11],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 206.23],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 215.49],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 173.74],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 177.49],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 182.21],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 186.43],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 190.96],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 194.22],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 198.92],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 204.29],
                ],
            ],
            [
                'name' => 'Cennik - MEDIUM & OPTIMA biała PCV',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'medium',
                        ],
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'optima',
                        ]
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'bialy_pcv',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 80.56],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 86.98],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 93.02],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 99.71],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 105.09],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 112.69],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 117.57],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 125.53],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 133.75],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 141.60],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 147.64],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 99.58],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 103.69],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 109.99],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 116.28],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 122.05],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 128.75],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 134.27],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 139.92],
                ],
            ],
            [
                'name' => 'Cennik - MEDIUM & OPTIMA biała ALU',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'medium',
                        ],
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'optima',
                        ]
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'bialy_aluminium',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 106.37],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 111.78],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 117.70],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 125.53],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 131.44],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 137.21],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 144.42],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 149.43],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 156.74],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 163.18],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 170.49],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 137.47],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 140.43],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 144.17],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 147.50],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 151.10],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 153.67],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 157.40],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 161.63],
                ],
            ],
            [
                'name' => 'Cennik - MEDIUM & OPTIMA kolor ALU',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'medium',
                        ],
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'optima',
                        ]
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'orzech_aluminium',
                            'dab_jasny_aluminium',
                            'dab_ciemny_aluminium',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 138.29],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 145.30],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 152.99],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 163.19],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 170.87],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 178.39],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 187.74],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 194.26],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 203.77],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 212.12],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 221.65],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 178.71],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 182.56],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 187.41],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 191.75],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 196.42],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 199.77],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 204.61],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 210.12],
                ],
            ],
            [
                'name' => 'Cennik - B500 & ORIENTAL biała PCV',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'b500',
                        ],
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'oriental',
                        ],
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'bialy_pcv',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 81.82],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 94.93],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 106.29],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 118.05],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 129.79],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 142.65],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 154.90],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 166.39],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 178.25],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 191.24],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 204.61],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 106.05],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 116.80],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 128.66],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 139.16],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 151.27],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 162.65],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 174.13],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 185.25],
                ],
            ],
            [
                'name' => 'Cennik - B500 & ORIENTAL biała ALU',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'b500',
                        ],
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'oriental',
                        ],
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'bialy_aluminium',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 109.56],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 117.09],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 131.66],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 146.53],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 160.15],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 175.00],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 186.75],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 202.73],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 216.98],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 232.34],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 249.83],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 184.37],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 188.74],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 193.36],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 198.23],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 202.48],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 206.48],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 210.99],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 215.10],
                ],
            ],
            [
                'name' => 'Cennik - B500 & ORIENTAL kolor ALU',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'b500',
                        ],
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'oriental',
                        ],
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'orzech_aluminium',
                            'dab_jasny_aluminium',
                            'dab_ciemny_aluminium',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 142.41],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 152.22],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 171.16],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 190.47],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 208.17],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 227.50],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 242.77],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 263.56],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 282.06],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 302.03],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 324.78],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 239.68],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 245.36],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 251.37],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 257.71],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 263.22],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 268.43],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 274.28],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 279.64],
                ],
            ],
            [
                'name' => 'Cennik - TERMO biała PCV',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'termo',
                        ]
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'bialy_pcv',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 90],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 104.43],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 116.93],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 129.84],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 142.77],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 156.92],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 170.37],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 183.04],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 196.08],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 210.36],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 225.08],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 116.66],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 128.48],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 141.53],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 153.07],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 166.40],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 178.91],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 191.54],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 203.76],
                ],
            ],
            [
                'name' => 'Cennik - TERMO biała ALU',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'termo',
                        ]
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'bialy_aluminium',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 120.50],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 128.79],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 144.83],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 161.19],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 176.15],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 192.51],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 205.42],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 223.01],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 238.67],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 255.58],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 274.81],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 202.81],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 207.63],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 212.71],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 218.06],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 222.73],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 227.12],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 232.07],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 236.62],
                ],
            ],
            [
                'name' => 'Cennik - TERMO kolor ALU',
                'conditions' => [
                    'collections' => [
                        [
                            'product' => 'rolety_w_kasecie',
                            'attribute' => 'kolekcja_rolet',
                            'collection' => 'kolekcja_rolet_w_kasecie',
                            'collection_item' => 'termo',
                        ]
                    ],
                    'attribute' => [
                        'product' => 'rolety_w_kasecie',
                        'attribute' => 'rodzaj_i_kolor_osprzetu',
                        'attribute_values' => [
                            'orzech_aluminium',
                            'dab_jasny_aluminium',
                            'dab_ciemny_aluminium',
                        ],
                    ],
                ],
                'price_list' => [
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 0, 'max_h' => 150, 'price' => 156.65],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 0, 'max_h' => 150, 'price' => 167.43],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 0, 'max_h' => 150, 'price' => 188.28],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 0, 'max_h' => 150, 'price' => 209.53],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 0, 'max_h' => 150, 'price' => 229.01],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 0, 'max_h' => 150, 'price' => 250.26],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 0, 'max_h' => 150, 'price' => 267.04],
                    ['min_w' => 111.00, 'max_w' => 120.99, 'min_h' => 0, 'max_h' => 150, 'price' => 289.92],
                    ['min_w' => 121.00, 'max_w' => 130.99, 'min_h' => 0, 'max_h' => 150, 'price' => 310.26],
                    ['min_w' => 131.00, 'max_w' => 140.99, 'min_h' => 0, 'max_h' => 150, 'price' => 332.25],
                    ['min_w' => 141.00, 'max_w' => 150, 'min_h' => 0, 'max_h' => 150, 'price' => 357.25],
                    ['min_w' => 0.00, 'max_w' => 50.99, 'min_h' => 151, 'max_h' => 220, 'price' => 263.66],
                    ['min_w' => 51.00, 'max_w' => 60.99, 'min_h' => 151, 'max_h' => 220, 'price' => 269.91],
                    ['min_w' => 61.00, 'max_w' => 70.99, 'min_h' => 151, 'max_h' => 220, 'price' => 276.52],
                    ['min_w' => 71.00, 'max_w' => 80.99, 'min_h' => 151, 'max_h' => 220, 'price' => 283.48],
                    ['min_w' => 81.00, 'max_w' => 90.99, 'min_h' => 151, 'max_h' => 220, 'price' => 289.56],
                    ['min_w' => 91.00, 'max_w' => 100.99, 'min_h' => 151, 'max_h' => 220, 'price' => 295.25],
                    ['min_w' => 101.00, 'max_w' => 110.99, 'min_h' => 151, 'max_h' => 220, 'price' => 301.70],
                    ['min_w' => 111.00, 'max_w' => 120.00, 'min_h' => 151, 'max_h' => 220, 'price' => 307.59],
                ],
            ],
        ];
    }
}

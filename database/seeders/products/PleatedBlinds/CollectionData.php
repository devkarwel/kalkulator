<?php

namespace Database\Seeders\products\PleatedBlinds;

use App\Enums\AttributeInputType;
use App\Enums\AttributeInputVariant;
use App\Enums\AttributeSideColumn;

class CollectionData
{
    public static function get(): array
    {
        return [
            [
                'label' => 'Kolekcja rolet plisowanych',
                'attribute' => [
                    'label' => 'Kolekcja rolet',
                    'input_type' => AttributeInputType::COLLECTION,
                    'input_variant' => AttributeInputVariant::SELECT_IMAGE_SQUARE,
                    'column_side' => AttributeSideColumn::COLUMN_FULL,
                    'nr_step' => 2,
                ],
                'items' => [
                    [
                        'name' => 'elegance',
                        'cover_img' => 'elegance/plisa_elegance.jpg',
                        'dir' => 'elegance',
                        'items' => [
                            [
                                'name' => 'EL01',
                                'img' => 'elegance/EL01.jpg',
                            ],
                            [
                                'name' => 'EL02',
                                'img' => 'elegance/EL02.jpg',
                            ],
                            [
                                'name' => 'EL03',
                                'img' => 'elegance/EL03.jpg',
                            ],
                            [
                                'name' => 'EL04',
                                'img' => 'elegance/EL04.jpg',
                            ],
                            [
                                'name' => 'EL05',
                                'img' => 'elegance/EL05.jpg',
                            ],
                        ],
                    ],
                    [
                        'name' => 'melange',
                        'cover_img' => 'melange/plisa_melange.jpg',
                        'dir' => 'melange',
                        'items' => [
                            [
                                'name' => 'ME01',
                                'img' => 'melange/ME01.jpg',
                            ],
                            [
                                'name' => 'ME02',
                                'img' => 'melange/ME02.jpg',
                            ],
                            [
                                'name' => 'ME03',
                                'img' => 'melange/ME03.jpg',
                            ],
                            [
                                'name' => 'ME04',
                                'img' => 'melange/ME04.jpg',
                            ],
                            [
                                'name' => 'ME05',
                                'img' => 'melange/ME05.jpg',
                            ],
                        ],
                    ],
                    [
                        'name' => 'premium',
                        'cover_img' => 'premium/plisa_premium.jpg',
                        'dir' => 'premium',
                        'items' => [
                            [
                                'name' => 'PP01',
                                'img' => 'premium/PP01.jpg',
                            ],
                            [
                                'name' => 'PP02',
                                'img' => 'premium/PP02.jpg',
                            ],
                            [
                                'name' => 'PP03',
                                'img' => 'premium/PP03.jpg',
                            ],
                            [
                                'name' => 'PP04',
                                'img' => 'premium/PP04.jpg',
                            ],
                            [
                                'name' => 'PP05',
                                'img' => 'premium/PP05.jpg',
                            ],
                            [
                                'name' => 'PP06',
                                'img' => 'premium/PP06.jpg',
                            ],
                            [
                                'name' => 'PP07',
                                'img' => 'premium/PP07.jpg',
                            ],
                            [
                                'name' => 'PP08',
                                'img' => 'premium/PP08.jpg',
                            ],
                            [
                                'name' => 'PP09',
                                'img' => 'premium/PP09.jpg',
                            ],
                            [
                                'name' => 'PP10',
                                'img' => 'premium/PP10.jpg',
                            ],
                            [
                                'name' => 'PP11',
                                'img' => 'premium/PP11.jpg',
                            ],
                            [
                                'name' => 'PP12',
                                'img' => 'premium/PP12.jpg',
                            ],
                        ],
                    ],
                    [
                        'name' => 'termo',
                        'cover_img' => 'termo/plisa_termo.jpg',
                        'dir' => 'termo',
                        'items' => [
                            [
                                'name' => 'TE01',
                                'img' => 'termo/TE01.jpg',
                            ],
                            [
                                'name' => 'TE02',
                                'img' => 'termo/TE02.jpg',
                            ],
                            [
                                'name' => 'TE03',
                                'img' => 'termo/TE03.jpg',
                            ],
                            [
                                'name' => 'TE04',
                                'img' => 'termo/TE04.jpg',
                            ],
                            [
                                'name' => 'TE05',
                                'img' => 'termo/TE05.jpg',
                            ],
                            [
                                'name' => 'TE06',
                                'img' => 'termo/TE06.jpg',
                            ],
                            [
                                'name' => 'TE07',
                                'img' => 'termo/TE07.jpg',
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}

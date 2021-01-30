<?php

namespace App\Service;

use App\Repository\ProductRepository;

class Product
{
    /**
     * @var ProductRepository
     */
    private ProductRepository $repository;

    public function __construct(
        ProductRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function getCategories(): array
    {
        return [
            'chemia' => [
                'chemia domowa',
                'farby',
                'kleje',
                'oleje',
                'inne',
            ],
            'bio' => [
                'makulatura',
                'żywność',
                'inne',
            ],
            'odzież' => [
                'odzież męska',
                'odzież damska',
                'odzież dziecięca',
                'inne'
            ],
            'budowlane' => [
                'narzędzia',
                'odpady budowlane',
                'ciężki sprzęt',
            ],
            'elektronika' => [
                'komputery',
                'telefony',
                'zegarki',
                'aparaty',
                'inne'
            ],
            'rolnictwo' => [
                'maszyny rolnicze',
                'części do maszyn',
                'inne',
            ],
            'dla dzieci' => [
                'zabawki',
                'nauka i rozwój',
                'wózki',
                'meble dziecięce',
                'inne',
            ],
            'motoryzacja' => [
                'samochody',
                'części motoryzacyjne',
                'akcesoria motoryzacyjne',
                'jednoślady',
                'opony',
                'felgi',
                'inne',
            ],
            'surowce' => [],
            'sport' => [
                'odzież sportowa',
                'obuwie sportowe',
                'sprzęt sportowy',
                'inne',
            ],
            'AGD' => [],
            'RTV' => [],
            'meble' => [],
            'elektryka' => [
                'akumulatory',
                'baterie',
                'kable',
                'narzędzia elektryczne',
                'inne',
            ],
            'inne' => [],
        ];
    }
}

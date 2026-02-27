<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

final class HomeController extends Controller
{
    public function index(): void
    {
        $productModel = new Product();
        $autoData = [
            'BMW' => ['M3', 'M5', 'X5'],
            'Mercedes' => ['C-Class', 'E-Class', 'GLE'],
            'Audi' => ['A4', 'A6', 'Q7'],
            'Porsche' => ['911', 'Panamera', 'Cayenne'],
        ];

        $this->view('home/index', [
            'popularProducts' => $productModel->top(4),
            'newProducts' => $productModel->latest(4),
            'autoData' => $autoData,
            'meta' => [
                'title' => 'BLACKFORGE — премиальные автомобильные диски',
                'description' => 'Люксовые, спортивные, кованые и литые диски BLACKFORGE',
            ],
        ]);
    }
}

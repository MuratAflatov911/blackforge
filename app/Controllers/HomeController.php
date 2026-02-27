<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

final class HomeController extends Controller
{
    public function index(): void
    {
        $products = (new Product())->top(6);
        $this->view('home/index', [
            'products' => $products,
            'meta' => [
                'title' => 'BLACKFORGE — премиальные автомобильные диски',
                'description' => 'Люксовые, спортивные, кованые и литые диски BLACKFORGE',
            ],
        ]);
    }
}

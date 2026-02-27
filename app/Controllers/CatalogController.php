<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Lookup;
use App\Models\Product;

final class CatalogController extends Controller
{
    public function index(): void
    {
        $filters = [
            'diameter' => $_GET['diameter'] ?? null,
            'material' => $_GET['material'] ?? null,
            'type' => $_GET['type'] ?? null,
            'manufacturer_id' => $_GET['manufacturer_id'] ?? null,
            'sort' => $_GET['sort'] ?? 'new',
        ];

        $lookup = new Lookup();
        $this->view('catalog/index', [
            'products' => (new Product())->list($filters),
            'manufacturers' => $lookup->manufacturers(),
            'filters' => $filters,
            'meta' => ['title' => 'Каталог дисков BLACKFORGE'],
        ]);
    }
}

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
            'pcd' => $_GET['pcd'] ?? null,
            'width' => $_GET['width'] ?? null,
            'offset_et' => $_GET['offset_et'] ?? null,
            'manufacturer_id' => $_GET['manufacturer_id'] ?? null,
            'material' => $_GET['material'] ?? null,
            'type' => $_GET['type'] ?? null,
            'color' => $_GET['color'] ?? null,
            'price_min' => $_GET['price_min'] ?? null,
            'price_max' => $_GET['price_max'] ?? null,
            'in_stock' => $_GET['in_stock'] ?? null,
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

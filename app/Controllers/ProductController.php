<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

final class ProductController extends Controller
{
    public function show(array $params): void
    {
        $product = (new Product())->findBySlug($params['slug']);
        if ($product === null) {
            http_response_code(404);
            echo 'Товар не найден';
            return;
        }

        $this->view('product/show', [
            'product' => $product,
            'meta' => [
                'title' => $product['name'] . ' | BLACKFORGE',
                'description' => mb_substr((string) $product['description'], 0, 150),
            ],
        ]);
    }
}

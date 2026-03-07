<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Models\Product;
use App\Models\Review;

final class ProductController extends Controller
{
    public function show(array $params): void
    {
        $productModel = new Product();
        $product = $productModel->findBySlug($params['slug']);
        if ($product === null) {
            http_response_code(404);
            echo 'Товар не найден';
            return;
        }

        $reviewModel = new Review();
        $reviews = $reviewModel->byProduct((int) $product['id']);
        $rating = count($reviews) ? array_sum(array_column($reviews, 'rating')) / count($reviews) : 0;

        $this->view('product/show', [
            'product' => $product,
            'reviews' => $reviews,
            'rating' => round((float) $rating, 1),
            'recommended' => $productModel->recommended((int) $product['id'], 4),
            'meta' => [
                'title' => $product['name'] . ' | BLACKFORGE',
                'description' => mb_substr((string) $product['description'], 0, 150),
            ],
        ]);
    }

    public function addReview(array $params): void
    {
        if (!Csrf::check($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            return;
        }

        $product = (new Product())->findBySlug($params['slug']);
        if (!$product) {
            http_response_code(404);
            return;
        }

        $rating = max(1, min(5, (int) ($_POST['rating'] ?? 5)));
        $comment = trim((string) ($_POST['comment'] ?? ''));
        if ($comment !== '') {
            (new Review())->add((int) $product['id'], Auth::user()['id'] ?? null, $rating, $comment);
            $_SESSION['flash'] = 'Отзыв отправлен на модерацию';
        }

        $this->redirect('/product/' . $product['slug']);
    }

    public function compareToggle(): void
    {
        if (!Csrf::check($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            return;
        }
        $productId = (int) ($_POST['product_id'] ?? 0);
        $items = $_SESSION['compare'] ?? [];
        if (in_array($productId, $items, true)) {
            $_SESSION['compare'] = array_values(array_diff($items, [$productId]));
        } else {
            $items[] = $productId;
            $_SESSION['compare'] = array_slice(array_values(array_unique($items)), 0, 4);
        }
        $this->redirect('/compare');
    }

    public function compare(): void
    {
        $products = [];
        $model = new Product();
        foreach (($_SESSION['compare'] ?? []) as $id) {
            $p = $model->findById((int) $id);
            if ($p) {
                $products[] = $p;
            }
        }

        $this->view('product/compare', [
            'products' => $products,
            'meta' => ['title' => 'Сравнение товаров'],
        ]);
    }
}

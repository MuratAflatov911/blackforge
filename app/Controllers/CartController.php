<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Models\Product;

final class CartController extends Controller
{
    public function index(): void
    {
        $this->view('cart/index', ['cart' => $this->detailedCart(), 'meta' => ['title' => 'Корзина']]);
    }

    public function add(): void
    {
        if (!Csrf::check($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            echo 'CSRF token mismatch';
            return;
        }
        $productId = (int) ($_POST['product_id'] ?? 0);
        $qty = max(1, (int) ($_POST['quantity'] ?? 1));
        $_SESSION['cart'][$productId] = ($_SESSION['cart'][$productId] ?? 0) + $qty;
        $this->redirect('/cart');
    }

    public function update(): void
    {
        if (!Csrf::check($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            return;
        }
        foreach (($_POST['qty'] ?? []) as $pid => $qty) {
            $qty = max(0, (int) $qty);
            if ($qty === 0) {
                unset($_SESSION['cart'][(int) $pid]);
            } else {
                $_SESSION['cart'][(int) $pid] = $qty;
            }
        }
        $this->redirect('/cart');
    }

    private function detailedCart(): array
    {
        $items = [];
        $total = 0.0;
        $productModel = new Product();

        foreach ($_SESSION['cart'] ?? [] as $productId => $quantity) {
            $product = $productModel->findById((int) $productId);
            if (!$product) {
                continue;
            }
            $line = (float) $product['price'] * (int) $quantity;
            $total += $line;
            $items[] = ['id' => $product['id'], 'name' => $product['name'], 'price' => $product['price'], 'quantity' => $quantity, 'line' => $line];
        }

        return ['items' => $items, 'total' => $total];
    }
}

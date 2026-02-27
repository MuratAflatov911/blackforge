<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Csrf;
use App\Models\Product;

final class ProductAdminController extends BaseAdminController
{
    public function index(): void
    {
        $this->guard();
        $products = (new Product())->list(['sort' => 'new']);
        $this->view('admin/products/index', ['products' => $products, 'meta' => ['title' => 'Админ • Товары']]);
    }

    public function store(): void
    {
        $this->guard();
        if (!Csrf::check($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            return;
        }

        $name = trim((string) ($_POST['name'] ?? ''));
        $slug = trim((string) ($_POST['slug'] ?? ''));
        $price = (float) ($_POST['price'] ?? 0);
        $stock = (int) ($_POST['stock'] ?? 0);
        $imageUrl = trim((string) ($_POST['image_url'] ?? ''));

        if ($name === '' || $slug === '' || $price <= 0) {
            $_SESSION['flash'] = 'Заполните обязательные поля товара.';
            $this->redirect('/admin/products');
        }

        $db = \App\Core\Database::connection();
        $stmt = $db->prepare('INSERT INTO products (category_id, manufacturer_id, name, slug, description, diameter, pcd, width, offset_et, material, type, color, price, stock, popularity) VALUES (1,1,:name,:slug,:description,19,:pcd,8.5,35,:material,:type,:color,:price,:stock,1)');
        $stmt->execute([
            'name' => $name,
            'slug' => $slug,
            'description' => 'Товар добавлен из админ-панели',
            'pcd' => '5x112',
            'material' => 'литые',
            'type' => 'премиальные',
            'color' => 'black',
            'price' => $price,
            'stock' => $stock,
        ]);
        $productId = (int) $db->lastInsertId();

        if ($imageUrl !== '') {
            $imgStmt = $db->prepare('INSERT INTO product_images (product_id, image_url, source, sort_order) VALUES (:product_id, :image_url, :source, 1)');
            $imgStmt->execute(['product_id' => $productId, 'image_url' => $imageUrl, 'source' => 'url']);
        }

        $_SESSION['flash'] = 'Товар создан';
        $this->redirect('/admin/products');
    }
}

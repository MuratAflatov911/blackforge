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
        // В учебном примере CRUD сокращён до демо-страницы списка.
        $_SESSION['flash'] = 'Создание товара вынесено в заготовку CRUD.';
        $this->redirect('/admin/products');
    }
}

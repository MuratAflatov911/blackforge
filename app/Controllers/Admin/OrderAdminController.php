<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Order;

final class OrderAdminController extends BaseAdminController
{
    public function index(): void
    {
        $this->guard();
        $orders = (new Order())->allWithUsers();
        $this->view('admin/orders/index', ['orders' => $orders, 'meta' => ['title' => 'Админ • Заказы']]);
    }
}

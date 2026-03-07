<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Order;

final class DashboardController extends BaseAdminController
{
    public function index(): void
    {
        $this->guard();
        $stats = (new Order())->adminStats();
        $this->view('admin/dashboard/index', ['stats' => $stats, 'meta' => ['title' => 'Админ • Дашборд']]);
    }
}

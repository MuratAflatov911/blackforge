<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\User;

final class UserAdminController extends BaseAdminController
{
    public function index(): void
    {
        $this->guard();
        $users = (new User())->all();
        $this->view('admin/users/index', ['users' => $users, 'meta' => ['title' => 'Админ • Пользователи']]);
    }
}

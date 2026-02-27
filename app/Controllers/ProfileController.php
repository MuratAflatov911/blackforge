<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\User;

final class ProfileController extends Controller
{
    public function index(): void
    {
        $user = Auth::user();
        if (!$user) {
            $this->redirect('/login');
        }

        $orders = (new User())->orderHistory((int) $user['id']);
        $this->view('profile/index', [
            'user' => $user,
            'orders' => $orders,
            'meta' => ['title' => 'Личный кабинет'],
        ]);
    }
}

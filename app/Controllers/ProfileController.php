<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Models\Product;
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
            'favoritesCount' => count($_SESSION['favorites'] ?? []),
            'meta' => ['title' => 'Личный кабинет'],
        ]);
    }

    public function update(): void
    {
        if (!Csrf::check($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            return;
        }
        $user = Auth::user();
        if (!$user) {
            $this->redirect('/login');
        }

        (new User())->updateProfile((int) $user['id'], trim((string) ($_POST['full_name'] ?? '')), trim((string) ($_POST['phone'] ?? '')));
        $_SESSION['flash'] = 'Профиль обновлён';
        $this->redirect('/profile');
    }

    public function changePassword(): void
    {
        if (!Csrf::check($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            return;
        }
        $user = Auth::user();
        if (!$user) {
            $this->redirect('/login');
        }
        $new = (string) ($_POST['new_password'] ?? '');
        if (mb_strlen($new) < 8) {
            $_SESSION['flash'] = 'Пароль должен быть не короче 8 символов';
            $this->redirect('/profile');
        }

        (new User())->changePassword((int) $user['id'], password_hash($new, PASSWORD_DEFAULT));
        $_SESSION['flash'] = 'Пароль изменён';
        $this->redirect('/profile');
    }

    public function repeatOrder(): void
    {
        $user = Auth::user();
        if (!$user) {
            $this->redirect('/login');
        }

        $orderId = (int) ($_POST['order_id'] ?? 0);
        $items = (new User())->orderItems($orderId);
        foreach ($items as $item) {
            $_SESSION['cart'][(int) $item['product_id']] = (int) $item['quantity'];
        }

        $_SESSION['flash'] = 'Товары из заказа добавлены в корзину';
        $this->redirect('/cart');
    }

    public function stockNotify(): void
    {
        if (!Csrf::check($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            return;
        }
        $_SESSION['flash'] = 'Заявка на уведомление о поступлении принята';
        $this->redirect('/profile');
    }
}

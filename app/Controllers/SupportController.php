<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;

final class SupportController extends Controller
{
    public function about(): void { $this->view('pages/about', ['meta' => ['title' => 'О нас']]); }
    public function delivery(): void { $this->view('pages/delivery', ['meta' => ['title' => 'Доставка']]); }
    public function warranty(): void { $this->view('pages/warranty', ['meta' => ['title' => 'Гарантия']]); }
    public function privacy(): void { $this->view('pages/privacy', ['meta' => ['title' => 'Политика конфиденциальности']]); }

    public function newsletter(): void
    {
        if (!Csrf::check($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            return;
        }
        $_SESSION['flash'] = 'Подписка на новости оформлена.';
        $this->redirect('/');
    }

    public function chat(): void
    {
        if (!Csrf::check($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            return;
        }
        $_SESSION['flash'] = 'Сообщение в онлайн-чат отправлено, менеджер ответит в ближайшее время.';
        $this->redirect('/');
    }
}

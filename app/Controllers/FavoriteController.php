<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;

final class FavoriteController extends Controller
{
    public function index(): void
    {
        $this->view('favorites/index', ['favorites' => $_SESSION['favorites'] ?? [], 'meta' => ['title' => 'Избранное']]);
    }

    public function toggle(): void
    {
        if (!Csrf::check($_POST['_csrf'] ?? null)) {
            http_response_code(419);
            return;
        }

        $productId = (int) ($_POST['product_id'] ?? 0);
        if (Auth::user()) {
            // Для учебного проекта оставлено как сессионное зеркало, обычно здесь таблица favorites.
        }

        $favorites = $_SESSION['favorites'] ?? [];
        if (in_array($productId, $favorites, true)) {
            $_SESSION['favorites'] = array_values(array_diff($favorites, [$productId]));
        } else {
            $favorites[] = $productId;
            $_SESSION['favorites'] = array_values(array_unique($favorites));
        }
        $this->redirect('/favorites');
    }
}

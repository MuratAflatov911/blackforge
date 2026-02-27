<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;

abstract class BaseAdminController extends Controller
{
    protected function guard(): void
    {
        if (!Auth::checkAdmin()) {
            http_response_code(403);
            echo 'Доступ запрещён';
            exit;
        }
    }
}

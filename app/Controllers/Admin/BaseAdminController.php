<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;

abstract class BaseAdminController extends Controller
{
    protected function guard(): void
    {
        $user = Auth::user();
        $allowed = ['admin', 'manager', 'super-admin'];
        if (!$user || !in_array($user['role_slug'], $allowed, true)) {
            http_response_code(403);
            echo 'Доступ запрещён';
            exit;
        }
    }
}

<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\User;

final class Auth
{
    public static function user(): ?array
    {
        if (empty($_SESSION['user_id'])) {
            return null;
        }

        return (new User())->findById((int) $_SESSION['user_id']);
    }

    public static function login(array $user): void
    {
        $_SESSION['user_id'] = (int) $user['id'];
    }

    public static function logout(): void
    {
        unset($_SESSION['user_id']);
    }

    public static function checkAdmin(): bool
    {
        $user = self::user();
        return $user !== null && in_array($user['role_slug'], ['super-admin', 'manager', 'admin'], true);
    }
}

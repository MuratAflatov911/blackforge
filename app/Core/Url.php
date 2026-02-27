<?php

declare(strict_types=1);

namespace App\Core;

final class Url
{
    public static function basePath(): string
    {
        $base = defined('APP_BASE_PATH') ? APP_BASE_PATH : '';
        if ($base === '/') {
            return '';
        }

        return rtrim((string) $base, '/');
    }

    public static function to(string $path = '/'): string
    {
        $base = self::basePath();
        $path = '/' . ltrim($path, '/');

        if ($path === '/') {
            return $base !== '' ? $base . '/' : '/';
        }

        return $base . $path;
    }
}

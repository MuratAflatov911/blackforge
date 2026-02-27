<?php

declare(strict_types=1);

namespace App\Core;

final class View
{
    public static function render(string $template, array $data = []): void
    {
        extract($data, EXTR_SKIP);
        $meta = $data['meta'] ?? ['title' => 'BLACKFORGE'];
        $contentView = __DIR__ . '/../Views/' . $template . '.php';
        require __DIR__ . '/../Views/layouts/main.php';
    }

    public static function e(?string $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }

    public static function url(string $path = '/'): string
    {
        return Url::to($path);
    }
}

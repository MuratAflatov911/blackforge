<?php

declare(strict_types=1);

namespace App\Core;

final class Validator
{
    public static function email(string $email): bool
    {
        return (bool) filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function minLength(string $value, int $min): bool
    {
        return mb_strlen(trim($value)) >= $min;
    }

    public static function floatRange(float $value, float $min, float $max): bool
    {
        return $value >= $min && $value <= $max;
    }
}

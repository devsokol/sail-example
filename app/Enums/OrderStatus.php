<?php

declare(strict_types=1);

namespace App\Enums;

final class OrderStatus
{
    public const InProgress = 1;
    public const Done = 2;
    public const Archive = 3;

    public static function getAllowedValues(): array
    {
        return [
            self::InProgress,
            self::Done,
            self::Archive,
        ];
    }
}

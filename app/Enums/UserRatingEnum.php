<?php

namespace App\Enums;

enum UserRatingEnum: int
{
    case Poor = 1;
    case Fair = 2;
    case Good = 3;
    case Great = 4;
    case Excellent = 5;

    public function label(): string
    {
        return match($this) {
            self::Poor => 'Poor',
            self::Fair => 'Fair',
            self::Good => 'Good',
            self::Great => 'Great',
            self::Excellent => 'Excellent',
        };
    }
}

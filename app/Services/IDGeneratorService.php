<?php

namespace App\Services;

class IDGeneratorService
{
    public static function generateId($lastId = null, $prefix = 'US-')
    {
        return $prefix . str_pad('' . ($lastId + 1), 5, '0', STR_PAD_LEFT);
    }
}

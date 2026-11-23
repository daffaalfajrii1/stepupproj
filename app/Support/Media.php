<?php

namespace App\Support;

class Media
{
    public static function url(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        if (preg_match('#^https?://#i', $path)) {
            return $path;
        }

        return asset('uploads/'.ltrim($path, '/'));
    }
}

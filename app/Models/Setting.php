<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    public $timestamps = false;

    protected $fillable = ['key', 'value'];

    /** @var array<string, string>|null */
    protected static ?array $memo = null;

    public static function map(): array
    {
        if (self::$memo !== null) {
            return self::$memo;
        }

        try {
            if (! Schema::hasTable('settings')) {
                return self::$memo = [];
            }

            return self::$memo = static::query()->pluck('value', 'key')->all();
        } catch (\Throwable) {
            return self::$memo = [];
        }
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        $value = static::map()[$key] ?? null;

        if ($value === null || $value === '') {
            return $default;
        }

        return $value;
    }

    public static function putMany(array $pairs): void
    {
        foreach ($pairs as $key => $value) {
            static::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        self::$memo = null;
    }
}

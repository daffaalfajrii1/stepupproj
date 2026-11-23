<?php

namespace App\Models;

use App\Models\Concerns\Publishes;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use Publishes;

    protected $fillable = [
        'title', 'subtitle', 'year', 'description', 'is_published', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\Publishes;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use Publishes;

    protected $fillable = [
        'title', 'description', 'icon', 'is_published', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }
}

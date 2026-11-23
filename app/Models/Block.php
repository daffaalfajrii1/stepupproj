<?php

namespace App\Models;

use App\Models\Concerns\Publishes;
use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    use Publishes;

    protected $fillable = [
        'group', 'eyebrow', 'title', 'body', 'is_published', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }
}

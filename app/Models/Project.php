<?php

namespace App\Models;

use App\Models\Concerns\Publishes;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use Publishes;

    protected $fillable = [
        'title', 'slug', 'category', 'year', 'client', 'excerpt', 'body',
        'cover', 'gallery', 'tech', 'live_url', 'repo_url',
        'is_featured', 'is_published', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'gallery' => 'array',
            'tech' => 'array',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
        ];
    }
}

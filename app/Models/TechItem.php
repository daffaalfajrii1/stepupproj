<?php

namespace App\Models;

use App\Models\Concerns\Publishes;
use Illuminate\Database\Eloquent\Model;

class TechItem extends Model
{
    use Publishes;

    protected $fillable = [
        'name', 'category', 'description', 'is_published', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }
}

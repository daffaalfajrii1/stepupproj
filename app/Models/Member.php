<?php

namespace App\Models;

use App\Models\Concerns\Publishes;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use Publishes;

    protected $fillable = [
        'name', 'role', 'team', 'bio', 'image', 'tone',
        'link_one_label', 'link_one_url', 'link_two_label', 'link_two_url',
        'is_published', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'tone' => 'integer',
        ];
    }
}

<?php

namespace App\Models;

use App\Models\Concerns\Publishes;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use Publishes;

    protected $fillable = [
        'title', 'issuer', 'issued_on', 'credential_url', 'image',
        'description', 'is_published', 'sort_order',
    ];

    protected function casts(): array
    {
        return ['is_published' => 'boolean'];
    }
}

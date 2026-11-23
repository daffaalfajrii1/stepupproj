<?php

namespace App\Models\Concerns;

trait Publishes
{
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderByDesc('id');
    }
}

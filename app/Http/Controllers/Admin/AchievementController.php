<?php

namespace App\Http\Controllers\Admin;

use App\Models\Achievement;

class AchievementController extends CrudController
{
    protected function model(): string
    {
        return Achievement::class;
    }

    protected function title(): string
    {
        return 'Pencapaian';
    }

    protected function routeName(): string
    {
        return 'admin.achievements';
    }

    protected function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Judul', 'rules' => 'required|string|max:160'],
            ['name' => 'subtitle', 'label' => 'Subjudul', 'rules' => 'nullable|string|max:160'],
            ['name' => 'year', 'label' => 'Tahun', 'rules' => 'nullable|string|max:20'],
            ['name' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea', 'wide' => true, 'rules' => 'nullable|string'],
            ['name' => 'is_published', 'label' => 'Tampil di web', 'type' => 'checkbox', 'default' => true],
        ];
    }
}

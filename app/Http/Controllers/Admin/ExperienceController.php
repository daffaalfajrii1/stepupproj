<?php

namespace App\Http\Controllers\Admin;

use App\Models\Experience;

class ExperienceController extends CrudController
{
    protected function model(): string
    {
        return Experience::class;
    }

    protected function title(): string
    {
        return 'Pengalaman';
    }

    protected function routeName(): string
    {
        return 'admin.experiences';
    }

    protected function columns(): array
    {
        return [
            ['key' => 'period', 'label' => 'Periode'],
            ['key' => 'title', 'label' => 'Judul'],
            ['key' => 'organization', 'label' => 'Organisasi'],
            ['key' => 'is_published', 'label' => 'Status', 'type' => 'bool'],
        ];
    }

    protected function fields(): array
    {
        return [
            ['name' => 'period', 'label' => 'Periode', 'rules' => 'nullable|string|max:40', 'placeholder' => '2025'],
            ['name' => 'title', 'label' => 'Judul', 'rules' => 'required|string|max:160'],
            ['name' => 'organization', 'label' => 'Organisasi', 'rules' => 'nullable|string|max:160'],
            ['name' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea', 'wide' => true, 'rules' => 'nullable|string'],
            ['name' => 'is_published', 'label' => 'Tampil di web', 'type' => 'checkbox', 'default' => true],
        ];
    }
}

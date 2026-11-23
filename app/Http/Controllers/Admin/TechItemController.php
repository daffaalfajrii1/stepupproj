<?php

namespace App\Http\Controllers\Admin;

use App\Models\TechItem;

class TechItemController extends CrudController
{
    protected function model(): string
    {
        return TechItem::class;
    }

    protected function title(): string
    {
        return 'Tech stack';
    }

    protected function routeName(): string
    {
        return 'admin.tech-items';
    }

    protected function columns(): array
    {
        return [
            ['key' => 'name', 'label' => 'Nama'],
            ['key' => 'category', 'label' => 'Kategori'],
            ['key' => 'is_published', 'label' => 'Status', 'type' => 'bool'],
        ];
    }

    protected function fields(): array
    {
        return [
            ['name' => 'name', 'label' => 'Nama', 'rules' => 'required|string|max:80'],
            ['name' => 'category', 'label' => 'Kategori', 'type' => 'select', 'rules' => 'required|string|max:40', 'options' => [
                'Frontend' => 'Frontend',
                'Backend' => 'Backend',
                'Database' => 'Database',
                'Alat' => 'Alat',
            ]],
            ['name' => 'description', 'label' => 'Catatan', 'type' => 'textarea', 'wide' => true, 'rules' => 'nullable|string|max:300'],
            ['name' => 'is_published', 'label' => 'Tampil di web', 'type' => 'checkbox', 'default' => true],
        ];
    }
}

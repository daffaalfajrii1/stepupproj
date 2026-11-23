<?php

namespace App\Http\Controllers\Admin;

use App\Models\Block;

class BlockController extends CrudController
{
    protected function model(): string
    {
        return Block::class;
    }

    protected function title(): string
    {
        return 'Blok cerita';
    }

    protected function routeName(): string
    {
        return 'admin.blocks';
    }

    protected function hint(): string
    {
        return 'Masalah, metode, dan prinsip yang menyusun alur landing page.';
    }

    protected function columns(): array
    {
        return [
            ['key' => 'group', 'label' => 'Grup'],
            ['key' => 'title', 'label' => 'Judul'],
            ['key' => 'is_published', 'label' => 'Status', 'type' => 'bool'],
        ];
    }

    protected function fields(): array
    {
        return [
            ['name' => 'group', 'label' => 'Grup', 'type' => 'select', 'rules' => 'required|in:problem,method,principle', 'options' => [
                'problem' => 'Masalah',
                'method' => 'Metode',
                'principle' => 'Prinsip',
            ]],
            ['name' => 'eyebrow', 'label' => 'Label kecil', 'rules' => 'nullable|string|max:80', 'placeholder' => '01'],
            ['name' => 'title', 'label' => 'Judul', 'rules' => 'required|string|max:160'],
            ['name' => 'body', 'label' => 'Isi', 'type' => 'textarea', 'wide' => true, 'rules' => 'nullable|string'],
            ['name' => 'is_published', 'label' => 'Tampil di web', 'type' => 'checkbox', 'default' => true],
        ];
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Models\Member;

class MemberController extends CrudController
{
    protected function model(): string
    {
        return Member::class;
    }

    protected function title(): string
    {
        return 'Tim';
    }

    protected function routeName(): string
    {
        return 'admin.members';
    }

    protected function hint(): string
    {
        return 'Kartu gantung di atas landing. Kiri logo situs, kanan foto orang.';
    }

    protected function uploadDir(): string
    {
        return 'members';
    }

    protected function columns(): array
    {
        return [
            ['key' => 'image', 'label' => '', 'type' => 'image'],
            ['key' => 'name', 'label' => 'Nama'],
            ['key' => 'role', 'label' => 'Peran'],
            ['key' => 'is_published', 'label' => 'Status', 'type' => 'bool'],
        ];
    }

    protected function fields(): array
    {
        return [
            ['name' => 'name', 'label' => 'Nama', 'rules' => 'required|string|max:80'],
            ['name' => 'role', 'label' => 'Peran', 'rules' => 'nullable|string|max:80'],
            ['name' => 'team', 'label' => 'Tim / label', 'rules' => 'nullable|string|max:80', 'placeholder' => 'StepUp · Studio'],
            ['name' => 'tone', 'label' => 'Warna tali', 'type' => 'select', 'rules' => 'required|integer|between:1,5', 'options' => [
                1 => 'Biru',
                2 => 'Hijau',
                3 => 'Oranye',
                4 => 'Ungu',
                5 => 'Merah muda',
            ]],
            ['name' => 'bio', 'label' => 'Bio di balik kartu', 'type' => 'textarea', 'wide' => true, 'rules' => 'nullable|string|max:400'],
            ['name' => 'image', 'label' => 'Foto wajah', 'type' => 'file', 'wide' => true, 'help' => 'JPG atau PNG. Tampil di kanan kartu.'],
            ['name' => 'link_one_label', 'label' => 'Tautan 1', 'rules' => 'nullable|string|max:40', 'placeholder' => 'Email'],
            ['name' => 'link_one_url', 'label' => 'URL tautan 1', 'rules' => 'nullable|url|max:255'],
            ['name' => 'link_two_label', 'label' => 'Tautan 2', 'rules' => 'nullable|string|max:40', 'placeholder' => 'Portofolio'],
            ['name' => 'link_two_url', 'label' => 'URL tautan 2', 'rules' => 'nullable|url|max:255'],
            ['name' => 'is_published', 'label' => 'Tampil di web', 'type' => 'checkbox', 'default' => true],
        ];
    }
}

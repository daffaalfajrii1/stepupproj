<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;

class ServiceController extends CrudController
{
    protected function model(): string
    {
        return Service::class;
    }

    protected function title(): string
    {
        return 'Layanan';
    }

    protected function routeName(): string
    {
        return 'admin.services';
    }

    protected function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Judul', 'rules' => 'required|string|max:160'],
            ['name' => 'icon', 'label' => 'Ikon', 'type' => 'select', 'rules' => 'nullable|string|max:40', 'options' => [
                'window' => 'Jendela',
                'layout' => 'Tata letak',
                'flow' => 'Alur',
                'shield' => 'Perisai',
            ]],
            ['name' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea', 'wide' => true, 'rules' => 'nullable|string', 'help' => 'Kalimat pembuka, lalu baris kosong, lalu satu layanan per baris.'],
            ['name' => 'is_published', 'label' => 'Tampil di web', 'type' => 'checkbox', 'default' => true],
        ];
    }
}

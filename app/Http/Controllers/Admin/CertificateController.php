<?php

namespace App\Http\Controllers\Admin;

use App\Models\Certificate;

class CertificateController extends CrudController
{
    protected function model(): string
    {
        return Certificate::class;
    }

    protected function title(): string
    {
        return 'Sertifikat';
    }

    protected function routeName(): string
    {
        return 'admin.certificates';
    }

    protected function uploadDir(): string
    {
        return 'certificates';
    }

    protected function columns(): array
    {
        return [
            ['key' => 'image', 'label' => '', 'type' => 'image'],
            ['key' => 'title', 'label' => 'Judul'],
            ['key' => 'issuer', 'label' => 'Penerbit'],
            ['key' => 'is_published', 'label' => 'Status', 'type' => 'bool'],
        ];
    }

    protected function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Judul', 'rules' => 'required|string|max:160'],
            ['name' => 'issuer', 'label' => 'Penerbit', 'rules' => 'nullable|string|max:160'],
            ['name' => 'issued_on', 'label' => 'Tahun / tanggal', 'rules' => 'nullable|string|max:40'],
            ['name' => 'credential_url', 'label' => 'Tautan kredensial', 'rules' => 'nullable|url|max:255'],
            ['name' => 'description', 'label' => 'Deskripsi', 'type' => 'textarea', 'wide' => true, 'rules' => 'nullable|string'],
            ['name' => 'image', 'label' => 'Gambar sertifikat', 'type' => 'file', 'wide' => true, 'help' => 'JPG atau PNG. Gambar ini yang tampil di tab Sertifikat.'],
            ['name' => 'is_published', 'label' => 'Tampil di web', 'type' => 'checkbox', 'default' => true],
        ];
    }
}

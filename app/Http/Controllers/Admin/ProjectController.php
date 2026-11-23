<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProjectController extends CrudController
{
    protected function model(): string
    {
        return Project::class;
    }

    protected function title(): string
    {
        return 'Proyek';
    }

    protected function routeName(): string
    {
        return 'admin.projects';
    }

    protected function hint(): string
    {
        return 'Kartu ini tampil di tab Proyek. Detail memuat cerita, galeri, dan live preview.';
    }

    protected function uploadDir(): string
    {
        return 'projects';
    }

    protected function hasGallery(): bool
    {
        return true;
    }

    protected function columns(): array
    {
        return [
            ['key' => 'cover', 'label' => '', 'type' => 'image'],
            ['key' => 'title', 'label' => 'Judul'],
            ['key' => 'category', 'label' => 'Kategori'],
            ['key' => 'is_published', 'label' => 'Status', 'type' => 'bool'],
        ];
    }

    protected function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Judul', 'rules' => 'required|string|max:160'],
            ['name' => 'slug', 'label' => 'Slug URL', 'rules' => 'nullable|string|max:180', 'placeholder' => 'otomatis dari judul'],
            ['name' => 'category', 'label' => 'Kategori', 'rules' => 'nullable|string|max:80', 'placeholder' => 'Dashboard, Website, Otomasi'],
            ['name' => 'year', 'label' => 'Tahun', 'rules' => 'nullable|string|max:20'],
            ['name' => 'client', 'label' => 'Klien / konteks', 'rules' => 'nullable|string|max:120'],
            ['name' => 'excerpt', 'label' => 'Ringkasan', 'type' => 'textarea', 'wide' => true, 'rules' => 'nullable|string|max:500'],
            ['name' => 'body', 'label' => 'Cerita proyek', 'type' => 'textarea', 'wide' => true, 'rules' => 'nullable|string'],
            ['name' => 'tech', 'label' => 'Tech stack', 'type' => 'tags', 'wide' => true, 'rules' => 'nullable|string|max:500', 'help' => 'Pisahkan dengan koma. Contoh: Laravel, MySQL, Blade'],
            ['name' => 'live_url', 'label' => 'URL live preview', 'rules' => 'nullable|url|max:255'],
            ['name' => 'repo_url', 'label' => 'URL repositori', 'rules' => 'nullable|url|max:255'],
            ['name' => 'cover', 'label' => 'Gambar sampul', 'type' => 'file', 'wide' => true],
            ['name' => 'gallery', 'label' => 'Galeri', 'type' => 'gallery', 'wide' => true, 'help' => 'Bisa beberapa gambar. Centang untuk menghapus.'],
            ['name' => 'is_featured', 'label' => 'Unggulan', 'type' => 'checkbox'],
            ['name' => 'is_published', 'label' => 'Tampil di web', 'type' => 'checkbox', 'default' => true],
        ];
    }

    protected function mutate(array $data, Request $request, ?Model $item): array
    {
        $data['slug'] = $this->uniqueSlug((string) ($data['title'] ?? ''), $data['slug'] ?? null, $item);

        return $data;
    }
}

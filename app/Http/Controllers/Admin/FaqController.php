<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;

class FaqController extends CrudController
{
    protected function model(): string
    {
        return Faq::class;
    }

    protected function title(): string
    {
        return 'FAQ';
    }

    protected function routeName(): string
    {
        return 'admin.faqs';
    }

    protected function columns(): array
    {
        return [
            ['key' => 'question', 'label' => 'Pertanyaan'],
            ['key' => 'is_published', 'label' => 'Status', 'type' => 'bool'],
        ];
    }

    protected function fields(): array
    {
        return [
            ['name' => 'question', 'label' => 'Pertanyaan', 'wide' => true, 'rules' => 'required|string|max:200'],
            ['name' => 'answer', 'label' => 'Jawaban', 'type' => 'textarea', 'wide' => true, 'rules' => 'required|string'],
            ['name' => 'is_published', 'label' => 'Tampil di web', 'type' => 'checkbox', 'default' => true],
        ];
    }
}

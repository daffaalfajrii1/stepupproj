<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class CrudController extends Controller
{
    abstract protected function model(): string;

    abstract protected function title(): string;

    abstract protected function routeName(): string;

    abstract protected function fields(): array;

    protected function hint(): string
    {
        return '';
    }

    protected function uploadDir(): string
    {
        return 'media';
    }

    protected function hasGallery(): bool
    {
        return false;
    }

    protected function columns(): array
    {
        return [
            ['key' => 'title', 'label' => 'Judul'],
            ['key' => 'is_published', 'label' => 'Status', 'type' => 'bool'],
        ];
    }

    protected function mutate(array $data, Request $request, ?Model $item): array
    {
        return $data;
    }

    public function index()
    {
        $model = $this->model();

        return view('admin.crud.index', [
            'items' => $model::query()->latest('id')->get(),
            'title' => $this->title(),
            'hint' => $this->hint(),
            'route' => $this->routeName(),
            'columns' => $this->columns(),
        ]);
    }

    public function create()
    {
        return view('admin.crud.form', $this->formData(null));
    }

    public function edit($id)
    {
        return view('admin.crud.form', $this->formData($this->find($id)));
    }

    public function store(Request $request)
    {
        $this->model()::create($this->payload($request, null));

        return redirect()->route($this->routeName().'.index')->with('ok', 'Tersimpan.');
    }

    public function update(Request $request, $id)
    {
        $item = $this->find($id);
        $item->update($this->payload($request, $item));

        return redirect()->route($this->routeName().'.index')->with('ok', 'Perubahan disimpan.');
    }

    public function destroy($id)
    {
        $item = $this->find($id);
        foreach (['cover', 'image'] as $column) {
            if (! empty($item->{$column})) {
                $this->unlink($item->{$column});
            }
        }
        if (is_array($item->gallery ?? null)) {
            foreach ($item->gallery as $path) {
                $this->unlink($path);
            }
        }
        $item->delete();

        return redirect()->route($this->routeName().'.index')->with('ok', 'Dihapus.');
    }

    protected function find($id): Model
    {
        $model = $this->model();

        return $model::query()->findOrFail($id);
    }

    protected function formData(?Model $item): array
    {
        return [
            'item' => $item,
            'title' => $this->title(),
            'hint' => $this->hint(),
            'route' => $this->routeName(),
            'fields' => $this->fields(),
        ];
    }

    protected function payload(Request $request, ?Model $item): array
    {
        $request->validate($this->rules(), [], $this->attributes());
        $data = [];

        foreach ($this->fields() as $field) {
            $name = $field['name'];
            $type = $field['type'] ?? 'text';

            if ($type === 'checkbox') {
                $data[$name] = $request->boolean($name);
            } elseif ($type === 'file') {
                if ($request->hasFile($name)) {
                    if ($item && ! empty($item->{$name})) {
                        $this->unlink($item->{$name});
                    }
                    $data[$name] = $request->file($name)->store($this->uploadDir(), 'public');
                }
            } elseif ($type === 'gallery') {
                continue;
            } elseif ($type === 'tags') {
                $data[$name] = collect(preg_split('/,/', (string) $request->input($name, '')))
                    ->map(fn ($value) => trim($value))
                    ->filter()
                    ->values()
                    ->all();
            } elseif ($type === 'number') {
                $data[$name] = (int) $request->input($name, 0);
            } else {
                $value = $request->input($name);
                $data[$name] = ($value === '' || $value === null) ? null : $value;
            }
        }

        if ($this->hasGallery()) {
            $data['gallery'] = $this->gallery($request, $item);
        }

        return $this->mutate($data, $request, $item);
    }

    protected function rules(): array
    {
        $rules = [];
        foreach ($this->fields() as $field) {
            $type = $field['type'] ?? 'text';
            if ($type === 'file') {
                $rules[$field['name']] = 'nullable|image|max:8192';
            } elseif ($type === 'gallery') {
                $rules['gallery'] = 'nullable|array';
                $rules['gallery.*'] = 'image|max:8192';
            } elseif (! empty($field['rules'])) {
                $rules[$field['name']] = $field['rules'];
            }
        }

        return $rules;
    }

    protected function attributes(): array
    {
        $attributes = [];
        foreach ($this->fields() as $field) {
            $attributes[$field['name']] = strtolower($field['label']);
        }

        return $attributes;
    }

    protected function gallery(Request $request, ?Model $item): array
    {
        $paths = $item && is_array($item->gallery) ? $item->gallery : [];
        $remove = (array) $request->input('remove_gallery', []);
        $kept = [];
        foreach ($paths as $path) {
            if (in_array($path, $remove, true)) {
                $this->unlink($path);
                continue;
            }
            $kept[] = $path;
        }
        foreach ($request->file('gallery', []) as $file) {
            $kept[] = $file->store($this->uploadDir(), 'public');
        }

        return $kept;
    }

    protected function unlink(?string $path): void
    {
        if (! $path || str_contains($path, '..')) {
            return;
        }
        $full = public_path('uploads/'.ltrim($path, '/'));
        if (is_file($full)) {
            unlink($full);
        }
    }

    protected function uniqueSlug(string $title, ?string $requested, ?Model $item): string
    {
        $base = Str::slug((string) $requested);
        if ($base === '') {
            $base = Str::slug($title);
        }
        if ($base === '') {
            $base = 'proyek';
        }
        $slug = $base;
        $n = 1;
        $model = $this->model();
        while ($model::where('slug', $slug)->when($item, fn ($query) => $query->whereKeyNot($item->getKey()))->exists()) {
            $slug = $base.'-'.(++$n);
        }

        return $slug;
    }
}

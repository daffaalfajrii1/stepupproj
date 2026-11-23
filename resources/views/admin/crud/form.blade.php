@extends('layouts.admin')

@section('title', ($item ? 'Ubah' : 'Tambah').' '.$title)

@section('content')
    <header class="page-head">
        <h1>{{ $item ? 'Ubah' : 'Tambah' }} {{ strtolower($title) }}</h1>
        <a href="{{ route($route.'.index') }}">Kembali</a>
    </header>
    @if ($errors->any())
        <div class="alert" role="alert" tabindex="-1" id="form-errors">
            <p>Periksa isian berikut.</p>
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    <form class="glass form-card" method="post" enctype="multipart/form-data" action="{{ $item ? route($route.'.update', $item) : route($route.'.store') }}">
        @csrf
        @if ($item) @method('PUT') @endif
        <div class="form-grid">
            @foreach ($fields as $field)
                @php
                    $type = $field['type'] ?? 'text';
                    $name = $field['name'];
                    $current = $item?->{$name};
                    if ($type === 'tags' && is_array($current)) $current = implode(', ', $current);
                    $value = old($name, $current);
                    $invalid = $errors->has($name);
                @endphp
                <div class="field {{ !empty($field['wide']) ? 'wide' : '' }}">
                    @if ($type === 'checkbox')
                        @php
                            $checked = $errors->any()
                                ? (bool) old($name)
                                : ($item ? (bool) $item->{$name} : (bool) ($field['default'] ?? false));
                        @endphp
                        <label class="check"><input type="checkbox" name="{{ $name }}" value="1" @checked($checked)> {{ $field['label'] }}</label>
                    @elseif ($type === 'file' || $type === 'gallery')
                        <label for="{{ $name }}">{{ $field['label'] }}</label>
                        <input id="{{ $name }}" name="{{ $type === 'gallery' ? 'gallery[]' : $name }}" type="file" accept="image/*" @if($type === 'gallery') multiple @endif aria-invalid="{{ $invalid ? 'true' : 'false' }}">
                        @if ($type === 'file' && $item && $item->{$name})
                            <img class="thumb" src="{{ \App\Support\Media::url($item->{$name}) }}" alt="">
                        @endif
                        @if ($type === 'gallery' && $item && is_array($item->gallery))
                            <div class="thumbs">
                                @foreach ($item->gallery as $path)
                                    <label class="thumb-check">
                                        <img src="{{ \App\Support\Media::url($path) }}" alt="">
                                        <input type="checkbox" name="remove_gallery[]" value="{{ $path }}"> Hapus
                                    </label>
                                @endforeach
                            </div>
                        @endif
                    @elseif ($type === 'textarea')
                        <label for="{{ $name }}">{{ $field['label'] }}</label>
                        <textarea id="{{ $name }}" name="{{ $name }}" aria-invalid="{{ $invalid ? 'true' : 'false' }}">{{ $value }}</textarea>
                    @elseif ($type === 'select')
                        <label for="{{ $name }}">{{ $field['label'] }}</label>
                        <select id="{{ $name }}" name="{{ $name }}">
                            @foreach ($field['options'] as $optionValue => $optionLabel)
                                <option value="{{ $optionValue }}" @selected((string) $value === (string) $optionValue)>{{ $optionLabel }}</option>
                            @endforeach
                        </select>
                    @else
                        <label for="{{ $name }}">{{ $field['label'] }}</label>
                        <input id="{{ $name }}" name="{{ $name }}" type="{{ $type === 'number' ? 'number' : ($type === 'tags' ? 'text' : 'text') }}" value="{{ $value }}" placeholder="{{ $field['placeholder'] ?? '' }}" aria-invalid="{{ $invalid ? 'true' : 'false' }}" @if($type === 'number') min="0" @endif>
                    @endif
                    @if (!empty($field['help']))<small>{{ $field['help'] }}</small>@endif
                </div>
            @endforeach
        </div>
        <button class="btn btn-light" type="submit">Simpan</button>
    </form>
    <script>
        document.getElementById('form-errors')?.focus();
    </script>
@endsection

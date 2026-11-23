@extends('layouts.admin')

@section('title', 'Pengaturan')

@section('content')
    <header class="page-head">
        <h1>Pengaturan</h1>
        <p class="muted">Teks landing, identitas, dan WhatsApp.</p>
    </header>
    @if ($errors->any())
        <div class="alert" role="alert" tabindex="-1">
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif
    <form class="glass form-card" method="post" enctype="multipart/form-data" action="{{ route('admin.settings.update') }}">
        @csrf
        @foreach ($groups as $group)
            <h2>{{ $group['title'] }}</h2>
            <div class="form-grid">
                @foreach ($group['fields'] as $field)
                    @php
                        $name = $field['name'];
                        $type = $field['type'] ?? 'text';
                        $value = old($name, $site[$name] ?? '');
                    @endphp
                    <div class="field {{ !empty($field['wide']) ? 'wide' : '' }}">
                        <label for="{{ $name }}">{{ $field['label'] }}</label>
                        @if ($type === 'textarea')
                            <textarea id="{{ $name }}" name="{{ $name }}" @if (!empty($field['rows'])) rows="{{ $field['rows'] }}" @endif>{{ $value }}</textarea>
                        @else
                            <input id="{{ $name }}" name="{{ $name }}" value="{{ $value }}">
                        @endif
                        @if (!empty($field['help']))<small>{{ $field['help'] }}</small>@endif
                    </div>
                @endforeach
            </div>
        @endforeach
        <div class="field">
            <label for="logo">Logo</label>
            <input id="logo" name="logo" type="file" accept="image/*">
            @if (!empty($site['logo']))
                <img class="thumb" src="{{ \App\Support\Media::url($site['logo']) }}" alt="">
            @endif
        </div>
        <button class="btn btn-light" type="submit">Simpan pengaturan</button>
    </form>

    <form class="glass form-card" method="post" action="{{ route('admin.password') }}">
        @csrf
        <h2>Kata sandi</h2>
        <div class="form-grid">
            <div class="field"><label for="current_password">Kata sandi sekarang</label><input id="current_password" name="current_password" type="password" required autocomplete="current-password"></div>
            <div class="field"><label for="password">Kata sandi baru</label><input id="password" name="password" type="password" required autocomplete="new-password"></div>
            <div class="field wide"><label for="password_confirmation">Ulangi kata sandi baru</label><input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"></div>
        </div>
        <button class="btn btn-line" type="submit">Perbarui kata sandi</button>
    </form>
@endsection

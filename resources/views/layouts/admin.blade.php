<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>@yield('title', 'Admin') — {{ $site['site_name'] ?? 'StepUp' }}</title>
    <link rel="icon" href="{{ \App\Support\Media::url($site['logo'] ?? null) ?: asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin">
@auth
    <div class="shell">
        <aside class="side glass" id="admin-nav">
            <a class="logo" href="{{ route('admin.dashboard') }}">
                @if ($mark = \App\Support\Media::url($site['logo'] ?? null))
                    <img src="{{ $mark }}" alt="{{ $site['site_name'] ?? 'StepUp' }}">
                @else
                    {{ $site['site_name'] ?? 'StepUp' }}
                @endif
            </a>
            <nav aria-label="Admin">
                <a href="{{ route('admin.dashboard') }}" @class(['is-on' => request()->routeIs('admin.dashboard')])>Ringkasan</a>
                <a href="{{ route('admin.members.index') }}" @class(['is-on' => request()->routeIs('admin.members.*')])>Tim</a>
                <a href="{{ route('admin.projects.index') }}" @class(['is-on' => request()->routeIs('admin.projects.*')])>Proyek</a>
                <a href="{{ route('admin.certificates.index') }}" @class(['is-on' => request()->routeIs('admin.certificates.*')])>Sertifikat</a>
                <a href="{{ route('admin.achievements.index') }}" @class(['is-on' => request()->routeIs('admin.achievements.*')])>Pencapaian</a>
                <a href="{{ route('admin.tech-items.index') }}" @class(['is-on' => request()->routeIs('admin.tech-items.*')])>Tech stack</a>
                <a href="{{ route('admin.experiences.index') }}" @class(['is-on' => request()->routeIs('admin.experiences.*')])>Pengalaman</a>
                <a href="{{ route('admin.services.index') }}" @class(['is-on' => request()->routeIs('admin.services.*')])>Layanan</a>
                <a href="{{ route('admin.blocks.index') }}" @class(['is-on' => request()->routeIs('admin.blocks.*')])>Blok cerita</a>
                <a href="{{ route('admin.faqs.index') }}" @class(['is-on' => request()->routeIs('admin.faqs.*')])>FAQ</a>
                <a href="{{ route('admin.inquiries.index') }}" @class(['is-on' => request()->routeIs('admin.inquiries.*')])>Pesan</a>
                <a href="{{ route('admin.settings.edit') }}" @class(['is-on' => request()->routeIs('admin.settings.*')])>Pengaturan</a>
            </nav>
            <form method="post" action="{{ route('admin.logout') }}">
                @csrf
                <button class="btn btn-line" type="submit">Keluar</button>
            </form>
        </aside>
        <div class="main">
            <div class="topbar">
                <button class="menu-btn" type="button" data-admin-nav aria-expanded="false" aria-controls="admin-nav">Menu</button>
                <a href="{{ route('home') }}" target="_blank" rel="noopener">Lihat situs</a>
            </div>
            @if (session('ok'))
                <div class="toast" role="status">{{ session('ok') }}</div>
            @endif
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('js/admin.js') }}"></script>
@else
    @yield('content')
@endauth
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $pageTitle = trim($__env->yieldContent('title', $site['meta_title'] ?? 'StepUp Project'));
        $pageDescription = trim($__env->yieldContent('description', $site['meta_description'] ?? ''));
        $pageRobots = trim($__env->yieldContent('robots', 'index, follow'));
        $pageCanonical = trim($__env->yieldContent('canonical', url()->current()));
        $shareImage = trim($__env->yieldContent('og_image', \App\Support\Media::url($site['logo'] ?? null) ?? ''));
    @endphp
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <meta name="robots" content="{{ $pageRobots }}">
    <link rel="canonical" href="{{ $pageCanonical }}">
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="{{ $site['site_name'] ?? 'StepUp' }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ $pageCanonical }}">
    @if ($shareImage !== '')
        <meta property="og:image" content="{{ $shareImage }}">
        <meta name="twitter:image" content="{{ $shareImage }}">
    @endif
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    <meta name="theme-color" content="#000000">
    <link rel="icon" href="{{ \App\Support\Media::url($site['logo'] ?? null) ?: asset('favicon.svg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700&family=Space+Grotesk:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/site.css') }}">
</head>
<body>
    <a class="skip" href="#isi">Lewati ke isi</a>
    <div class="progress" aria-hidden="true"><span id="read-progress"></span></div>
    <canvas id="net" aria-hidden="true"></canvas>
    <div class="page">
        @include('partials.header')
        <main id="isi">
            @yield('content')
        </main>
        @include('partials.map')
        @include('partials.footer')
    </div>
    @include('partials.wa')
    @if (session('ok'))
        <div class="toast" role="status">{{ session('ok') }}</div>
    @endif
    <script src="{{ asset('js/site.js') }}"></script>
</body>
</html>

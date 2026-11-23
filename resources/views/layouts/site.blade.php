<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', $site['meta_title'] ?? 'StepUp Project')</title>
    <meta name="description" content="@yield('description', $site['meta_description'] ?? '')">
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

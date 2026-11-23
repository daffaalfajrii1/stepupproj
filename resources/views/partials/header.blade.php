@php
    $logo = \App\Support\Media::url($site['logo'] ?? null);
    $home = route('home');
@endphp
<header class="site-header">
    <a class="logo" href="{{ $home }}">
        @if ($logo)
            <img src="{{ $logo }}" alt="{{ $site['site_name'] ?? 'StepUp' }}">
        @else
            <svg viewBox="0 0 32 32" aria-hidden="true"><path d="M7 23h7v-6h7V9" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>{{ $site['site_name'] ?? 'StepUp' }}</span>
        @endif
    </a>
    <button class="menu-btn" type="button" aria-expanded="false" aria-controls="site-nav">Menu</button>
    <nav id="site-nav" class="nav-pill" aria-label="Utama">
        <a href="{{ $home }}" @if(request()->routeIs('home')) aria-current="page" @endif>Beranda</a>
        <a href="{{ route('portfolio.index') }}" @if(request()->routeIs('portfolio.index')) aria-current="page" @endif>Portofolio</a>
        <a href="{{ $home }}#layanan">Layanan</a>
        <a href="{{ $home }}#jejak">Jejak</a>
        <a href="{{ $home }}#kontak">Kontak</a>
    </nav>
    <a class="btn btn-light header-cta" href="{{ $home }}#kontak">Hubungi</a>
</header>

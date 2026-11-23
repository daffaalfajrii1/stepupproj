@php
    $phone = trim((string) ($site['phone'] ?? ''));
    $tel = preg_replace('/[^\d+]/', '', $phone);
@endphp
@php
    $socials = [
        ['instagram', 'Instagram'],
        ['tiktok', 'TikTok'],
        ['linkedin', 'LinkedIn'],
        ['youtube', 'YouTube'],
        ['facebook', 'Facebook'],
        ['x', 'X'],
        ['github', 'GitHub'],
    ];
@endphp
<footer class="site-footer">
    <div class="container">
        @php $visibleSocials = collect($socials)->filter(fn ($item) => preg_match('#^https?://#i', trim((string) ($site[$item[0]] ?? '')))); @endphp
        @if ($visibleSocials->isNotEmpty())
            <div class="find-us">
                <p class="footer-label">Find us</p>
                <div class="social-row">
                    @foreach ($visibleSocials as [$key, $label])
                        <a href="{{ $site[$key] }}" target="_blank" rel="noopener noreferrer">
                            @include('partials.social-icon', ['name' => $key])
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
        <div class="footer-grid">
        <div>
            <strong>{{ $site['site_name'] ?? 'StepUp' }}</strong>
            <p>{{ $site['footer_note'] ?? '' }}</p>
        </div>
        <div>
            <p class="footer-label">Kontak</p>
            @if ($phone !== '')
                <a href="tel:{{ $tel }}">{{ $phone }}</a>
            @endif
            @if (!empty($site['email']))
                <a href="mailto:{{ $site['email'] }}">{{ $site['email'] }}</a>
            @endif
            @if (!empty($site['address']))
                <p>{{ $site['address'] }}</p>
            @endif
        </div>
        <nav aria-label="Footer">
            <p class="footer-label">Halaman</p>
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('portfolio.index') }}">Portofolio</a>
            <a href="{{ route('home') }}#kontak">Kontak</a>
            <a href="{{ route('admin.dashboard') }}">Admin</a>
        </nav>
        </div>
    </div>
</footer>

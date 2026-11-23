@php $key = strtolower($name); @endphp
<svg class="mark mark-{{ \Illuminate\Support\Str::slug($key) }}" viewBox="0 0 32 32" aria-hidden="true">
    @switch($key)
        @case('laravel')
            <path d="M6 26V6l10 8 10-8v20" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
            @break
        @case('react')
            <circle cx="16" cy="16" r="2.2" fill="currentColor"/>
            <ellipse cx="16" cy="16" rx="11" ry="4.2" fill="none" stroke="currentColor" stroke-width="1.6"/>
            <ellipse cx="16" cy="16" rx="11" ry="4.2" transform="rotate(60 16 16)" fill="none" stroke="currentColor" stroke-width="1.6"/>
            <ellipse cx="16" cy="16" rx="11" ry="4.2" transform="rotate(120 16 16)" fill="none" stroke="currentColor" stroke-width="1.6"/>
            @break
        @case('javascript')
            <rect x="5" y="5" width="22" height="22" rx="3" fill="currentColor"/>
            <text x="8" y="22" fill="#111" font-size="11" font-family="Archivo, sans-serif" font-weight="700">JS</text>
            @break
        @case('html5')
            <path d="M7 5h18l-1.6 18L16 27l-7.4-4L7 5Z" fill="currentColor"/>
            <path d="M16 23.4V8h6.2l-.4 5H16" fill="#111" opacity=".35"/>
            @break
        @case('css3')
            <path d="M7 5h18l-1.6 18L16 27l-7.4-4L7 5Z" fill="currentColor"/>
            <path d="M16 23.4V8h6.2l-.4 5H16" fill="#fff" opacity=".45"/>
            @break
        @case('font awesome')
            <path d="M9 24V8h4.2c3.4 0 5.4 1.7 5.4 4.3 0 1.8-1 3.2-2.6 3.9L19.8 24h-3.2l-3-7H12v7H9Z" fill="currentColor"/>
            @break
        @case('python')
            <path d="M12 6h7a4 4 0 0 1 4 4v3H13a3 3 0 0 0-3 3v1H8a4 4 0 0 1-4-4V10a4 4 0 0 1 4-4h4Z" fill="currentColor"/>
            <path d="M20 26h-7a4 4 0 0 1-4-4v-3h10a3 3 0 0 0 3-3v-1h2a4 4 0 0 1 4 4v3a4 4 0 0 1-4 4h-4Z" fill="currentColor" opacity=".7"/>
            @break
        @case('php')
            <ellipse cx="16" cy="16" rx="12" ry="7" fill="none" stroke="currentColor" stroke-width="2"/>
            <text x="8.2" y="19" fill="currentColor" font-size="8" font-family="Archivo, sans-serif" font-weight="700">php</text>
            @break
        @case('mysql')
            <path d="M8 20c2-7 5-11 8-11s5 3 6 7c1 3 3 4 5 3-2 4-6 6-11 6-5 0-8-2-8-5Z" fill="currentColor"/>
            @break
        @case('supabase')
            <path d="M17 4 7 18h8l-1 10 11-16h-8l0-8Z" fill="currentColor"/>
            @break
        @case('firebase')
            <path d="M9 25 16 6l4 8 4-3-3 16H9Z" fill="currentColor"/>
            @break
        @case('xampp')
            <rect x="6" y="8" width="20" height="16" rx="3" fill="currentColor"/>
            <path d="M11 16h10M16 12v8" stroke="#111" stroke-width="1.8"/>
            @break
        @case('git')
            <circle cx="10" cy="8" r="2.2" fill="currentColor"/>
            <circle cx="10" cy="24" r="2.2" fill="currentColor"/>
            <circle cx="22" cy="14" r="2.2" fill="currentColor"/>
            <path d="M10 10.2v11.6M12 9.2c4 1 8 2.2 8 4.8" fill="none" stroke="currentColor" stroke-width="1.6"/>
            @break
        @case('github')
            <circle cx="16" cy="16" r="10" fill="currentColor"/>
            <circle cx="16" cy="16" r="4" fill="#111"/>
            @break
        @case('vite')
            <path d="M16 4 6 26h6l4-8 4 8h6L16 4Z" fill="currentColor"/>
            @break
        @case('vercel')
            <path d="M16 6 28 26H4L16 6Z" fill="currentColor"/>
            @break
        @default
            <circle cx="16" cy="16" r="10" fill="none" stroke="currentColor" stroke-width="1.8"/>
            <text x="16" y="20" text-anchor="middle" fill="currentColor" font-size="11" font-family="Archivo, sans-serif">{{ strtoupper(substr($name, 0, 1)) }}</text>
    @endswitch
</svg>

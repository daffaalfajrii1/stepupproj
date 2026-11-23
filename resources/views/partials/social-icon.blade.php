@php $name = $name ?? ''; @endphp
<svg viewBox="0 0 24 24" aria-hidden="true">
    @if ($name === 'instagram')
        <rect x="4" y="4" width="16" height="16" rx="4" fill="none" stroke="currentColor" stroke-width="1.6"/>
        <circle cx="12" cy="12" r="3.2" fill="none" stroke="currentColor" stroke-width="1.6"/>
        <circle cx="16.8" cy="7.2" r="0.8" fill="currentColor"/>
    @elseif ($name === 'tiktok')
        <path d="M14 6.2v8.1a3.2 3.2 0 1 1-2.2-3.05" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
        <path d="M14 6.2c.7 2 2.3 3.2 4.2 3.4" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
    @elseif ($name === 'linkedin')
        <rect x="4" y="4" width="16" height="16" rx="2" fill="none" stroke="currentColor" stroke-width="1.6"/>
        <path d="M8 10.5V16M8 8h.01M11.5 16v-3.2a1.8 1.8 0 0 1 3.6 0V16" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
    @elseif ($name === 'youtube')
        <rect x="3.5" y="7" width="17" height="10" rx="2.4" fill="none" stroke="currentColor" stroke-width="1.6"/>
        <path d="M11 10.2v3.6L15 12Z" fill="currentColor"/>
    @elseif ($name === 'facebook')
        <path d="M14 8h2V5.5h-2c-2 0-3.2 1.2-3.2 3.1V11H9v2.4h1.8V19H13v-5.6h2.2L15.5 11H13V8.8c0-.5.3-.8 1-.8Z" fill="currentColor"/>
    @elseif ($name === 'x')
        <path d="M6 6.5 17.5 17.5M17.5 6.5 6 17.5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
    @else
        <circle cx="12" cy="12" r="7.5" fill="none" stroke="currentColor" stroke-width="1.6"/>
        <path d="M9.2 14.6c.7 1 1.6 1.4 2.8 1.4 1.6 0 2.6-.8 2.6-2s-1-1.8-2.8-2.1c-1.5-.3-2.2-.7-2.2-1.6 0-.8.8-1.4 2-1.4.9 0 1.7.3 2.3 1" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
    @endif
</svg>

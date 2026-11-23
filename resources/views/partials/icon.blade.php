@php $name = $name ?? 'window'; @endphp
<svg viewBox="0 0 24 24" aria-hidden="true">
    @if ($name === 'layout')
        <rect x="4" y="4" width="7" height="7" rx="1.4" fill="none" stroke="currentColor" stroke-width="1.6"/>
        <rect x="13" y="4" width="7" height="7" rx="1.4" fill="none" stroke="currentColor" stroke-width="1.6"/>
        <rect x="4" y="13" width="16" height="7" rx="1.4" fill="none" stroke="currentColor" stroke-width="1.6"/>
    @elseif ($name === 'flow')
        <path d="M5 7h8M5 12h14M5 17h8" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
        <path d="M16 5.5 18.5 7 16 8.5M19 10.5 21.5 12 19 13.5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
    @elseif ($name === 'shield')
        <path d="M12 3.5 19 6.2v5.4c0 3.6-2.6 6.4-7 8.4-4.4-2-7-4.8-7-8.4V6.2L12 3.5Z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>
        <path d="M9 12.1 11 14l4-4.2" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
    @else
        <rect x="3.5" y="5" width="17" height="14" rx="2" fill="none" stroke="currentColor" stroke-width="1.6"/>
        <path d="M3.5 9h17" fill="none" stroke="currentColor" stroke-width="1.6"/>
    @endif
</svg>

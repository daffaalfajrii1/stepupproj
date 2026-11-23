@php $wa = \App\Support\Site::whatsapp($site); @endphp
@if ($wa)
    <div class="wa-dock">
        <div id="wa-panel" class="wa-panel glass" hidden>
            <p class="panel-kicker">WhatsApp</p>
            <h2>{{ $site['wa_panel_title'] ?? 'Ngobrol langsung' }}</h2>
            <p>{{ $site['wa_panel_body'] ?? '' }}</p>
            <a class="btn btn-light" href="{{ $wa }}" target="_blank" rel="noopener noreferrer">Lanjut ke WhatsApp</a>
        </div>
        <button class="wa-fab" type="button" aria-expanded="false" aria-controls="wa-panel">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 18.5 6.2 15A7.5 7.5 0 1 1 9 18.2L5 18.5Z" fill="none" stroke="currentColor" stroke-width="1.6"/><path d="M9 10.2c.2 1.4 1.6 2.8 3 3.2" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/></svg>
            <span>Chat</span>
        </button>
    </div>
@endif

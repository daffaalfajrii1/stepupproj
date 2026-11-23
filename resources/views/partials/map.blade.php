@php
    $src = \App\Support\Site::mapSrc($site['map_embed'] ?? '');
@endphp
@if ($src)
    <section class="map-band" aria-label="Peta lokasi">
        <iframe
            title="Peta lokasi"
            src="{{ $src }}"
            loading="lazy"
            referrerpolicy="no-referrer-when-downgrade"
            allowfullscreen
        ></iframe>
    </section>
@endif

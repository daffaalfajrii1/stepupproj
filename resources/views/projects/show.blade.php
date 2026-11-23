@extends('layouts.site')

@section('title', $project->title.' — '.($site['site_name'] ?? 'StepUp'))
@section('description', $project->excerpt ?: ($site['meta_description'] ?? ''))

@section('content')
    @php
        $cover = \App\Support\Media::url($project->cover);
        $live = $project->live_url && preg_match('#^https?://#i', $project->live_url) ? $project->live_url : null;
        $host = $live ? parse_url($live, PHP_URL_HOST) : 'pratinjau';
    @endphp
    <article class="section detail">
        <div class="container">
            <a class="back" href="{{ route('portfolio.index') }}">Kembali ke portofolio</a>
            <div class="detail-grid">
                <div class="glass preview">
                    <div class="browser-bar">
                        <i></i><i></i><i></i>
                        <span>{{ $host }}</span>
                        @if ($live && $cover)
                            <button type="button" data-preview-toggle aria-pressed="false">Lihat gambar</button>
                        @endif
                    </div>
                    @if ($live)
                        <iframe title="Live preview {{ $project->title }}" src="{{ route('projects.preview', $project->slug) }}" sandbox="allow-scripts allow-forms allow-popups allow-popups-to-escape-sandbox"></iframe>
                    @endif
                    @if ($cover)
                        <img class="preview-still {{ $live ? 'is-hidden' : '' }}" src="{{ $cover }}" alt="Tampilan {{ $project->title }}">
                    @endif
                    @if (! $live && ! $cover)
                        <div class="shot-fallback large">{{ \Illuminate\Support\Str::of($project->title)->substr(0, 1) }}</div>
                    @endif
                </div>
                <aside class="glass detail-side">
                    <p class="meta">{{ $project->category }} @if($project->year) · {{ $project->year }} @endif</p>
                    <h1>{{ $project->title }}</h1>
                    @if ($project->client)<p class="meta">{{ $project->client }}</p>@endif
                    <p>{{ $project->excerpt }}</p>
                    @if (is_array($project->tech) && count($project->tech))
                        <ul class="chips">
                            @foreach ($project->tech as $tech)
                                <li>{{ $tech }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="stack-actions">
                        @if ($live)
                            <a class="btn btn-light" href="{{ $live }}" target="_blank" rel="noopener noreferrer">Buka live</a>
                        @endif
                        @if ($project->repo_url)
                            <a class="btn btn-glass" href="{{ $project->repo_url }}" target="_blank" rel="noopener noreferrer">Repositori</a>
                        @endif
                        <a class="btn btn-line" href="{{ route('home') }}#kontak">Diskusi serupa</a>
                    </div>
                </aside>
            </div>
            @if ($project->body)
                <div class="glass prose detail-body">{!! nl2br(e($project->body)) !!}</div>
            @endif
            @if (is_array($project->gallery) && count($project->gallery))
                <div class="gallery">
                    @foreach ($project->gallery as $path)
                        @php $src = \App\Support\Media::url($path); @endphp
                        @if ($src)
                            <button type="button" class="shot" data-lightbox="{{ $src }}">
                                <img src="{{ $src }}" alt="Galeri {{ $project->title }}">
                            </button>
                        @endif
                    @endforeach
                </div>
            @endif
            @if ($more->isNotEmpty())
                <h2 class="more-title">Proyek lain</h2>
                <div class="grid grid-3">
                    @foreach ($more as $item)
                        <article class="glass project-card">
                            <div class="project-copy">
                                <h3><a href="{{ route('projects.show', $item->slug) }}">{{ $item->title }}</a></h3>
                                <p>{{ $item->excerpt }}</p>
                                <a class="btn btn-line" href="{{ route('projects.show', $item->slug) }}">Detail</a>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
    </article>
    <dialog id="lightbox">
        <form method="dialog"><button class="btn btn-light" type="submit">Tutup</button></form>
        <img alt="">
    </dialog>
@endsection

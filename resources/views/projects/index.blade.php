@extends('layouts.site')

@section('title', 'Portofolio — '.($site['site_name'] ?? 'StepUp'))
@section('description', 'Website, aplikasi, dan sistem yang sudah selesai dibangun oleh StepUp Project.')

@section('content')
    <section class="section">
        <div class="container">
            <a class="back" href="{{ route('home') }}">Kembali ke beranda</a>
            <div class="section-head">
                <p class="pill">Portofolio</p>
                <h1>Proyek yang pernah dibuat.</h1>
                <p class="lede">Website, aplikasi, dan sistem yang sudah selesai. Setiap pekerjaan bisa dibuka sampai detailnya.</p>
            </div>
            <div class="grid grid-3">
                @forelse ($projects as $project)
                    @php $cover = \App\Support\Media::url($project->cover); @endphp
                    <article class="glass project-card grid-item">
                        <a class="shot" href="{{ route('projects.show', $project->slug) }}">
                            @if ($cover)
                                <img src="{{ $cover }}" alt="Tampilan {{ $project->title }}">
                            @else
                                <span class="shot-fallback" aria-hidden="true">{{ \Illuminate\Support\Str::of($project->title)->substr(0, 1) }}</span>
                            @endif
                        </a>
                        <div class="project-copy">
                            @if ($project->category || $project->year)
                                <p class="meta">{{ $project->category }} @if($project->year) · {{ $project->year }} @endif</p>
                            @endif
                            <h2 class="card-title"><a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a></h2>
                            <p>{{ $project->excerpt }}</p>
                            <a class="btn btn-line" href="{{ route('projects.show', $project->slug) }}">Detail</a>
                        </div>
                    </article>
                @empty
                    <p class="muted">Belum ada proyek tayang.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection

@extends('layouts.site')

@section('content')
    <section class="hero" id="awal">
        @include('partials.lanyard')
        <p class="pill">{{ $site['hero_kicker'] }} <strong>{{ $site['hero_kicker_strong'] }}</strong></p>
        <h1>{{ $site['hero_title'] }} <em>{{ $site['hero_accent'] }}</em></h1>
        <p class="lede">{{ $site['hero_subtitle'] }}</p>
        <div class="hero-actions">
            <a class="btn btn-light" href="{{ route('portfolio.index') }}">Lihat portofolio</a>
            <a class="btn btn-glass" href="#kontak">Mulai percakapan</a>
        </div>
        <div class="marquee" data-marquee>
            <div class="marquee-label">
                <span>Dibangun dengan</span>
                <button type="button" data-marquee-toggle aria-pressed="false">Jeda</button>
            </div>
            <div class="marquee-window">
                <div class="marquee-track">
                    @php
                        $names = $techItems->pluck('name');
                        if ($names->isEmpty()) {
                            $names = collect(['Laravel', 'PHP', 'MySQL', 'Blade']);
                        }
                        $loopNames = $names->concat($names);
                    @endphp
                    @foreach ($loopNames as $name)
                        <span>{{ $name }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="masalah">
        <div class="container">
            <div class="section-head">
                <p class="pill">{{ $site['problem_kicker'] ?? 'Yang biasanya macet' }}</p>
                <h2>{{ $site['problem_title'] }}</h2>
                <p class="lede">{{ $site['problem_body'] }}</p>
            </div>
            <div class="grid grid-4">
                @forelse ($problems as $block)
                    <article class="glass card grid-item">
                        <span class="index">{{ $block->eyebrow }}</span>
                        <h3>{{ $block->title }}</h3>
                        @include('partials.block-copy', ['body' => $block->body])
                    </article>
                @empty
                    <p class="muted">Blok masalah belum diisi.</p>
                @endforelse
            </div>
            @if (!empty($site['problem_close']))
                <p class="close-line">{{ $site['problem_close'] }}</p>
            @endif
        </div>
    </section>

    <section class="section band" id="bukti">
        <div class="container stats">
            <p class="manifesto">{{ $site['manifesto'] }}</p>
            <dl>
                <div><dt>{{ $projectCount }}+</dt><dd>proyek tercatat</dd></div>
                <div><dt>{{ $site['stats_years'] }}</dt><dd>{{ $site['stats_years_label'] }}</dd></div>
                <div><dt>{{ $certificates->count() }}</dt><dd>sertifikat ditampilkan</dd></div>
            </dl>
        </div>
    </section>

    <section class="section" id="portofolio">
        <div class="container">
            <div class="section-head center">
                <p class="pill">{{ $site['portfolio_kicker'] ?? 'Portofolio' }}</p>
                <h2>{{ $site['portfolio_title'] ?? 'Portofolio' }}</h2>
            </div>
            <div class="tabs" role="tablist" aria-label="Isi portofolio">
                <button type="button" role="tab" id="tab-projects" aria-selected="true" aria-controls="panel-projects" data-tab="projects">Proyek</button>
                <button type="button" role="tab" id="tab-certificates" aria-selected="false" aria-controls="panel-certificates" data-tab="certificates" tabindex="-1">Sertifikat</button>
                <button type="button" role="tab" id="tab-achievements" aria-selected="false" aria-controls="panel-achievements" data-tab="achievements" tabindex="-1">Pencapaian</button>
                <button type="button" role="tab" id="tab-stack" aria-selected="false" aria-controls="panel-stack" data-tab="stack" tabindex="-1">Tech stack</button>
            </div>

            <div class="tab-panel" id="panel-projects" role="tabpanel" aria-labelledby="tab-projects" data-panel="projects">
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
                                <h3><a href="{{ route('projects.show', $project->slug) }}">{{ $project->title }}</a></h3>
                                <p>{{ $project->excerpt }}</p>
                                <a class="btn btn-line" href="{{ route('projects.show', $project->slug) }}">Detail</a>
                            </div>
                        </article>
                    @empty
                        <p class="muted">Belum ada proyek tayang. Tambah dari dashboard admin.</p>
                    @endforelse
                </div>
                @if ($projectCount > 6)
                    <p class="portfolio-more"><a class="btn btn-line" href="{{ route('portfolio.index') }}">Semua portofolio</a></p>
                @endif
            </div>

            <div class="tab-panel" id="panel-certificates" role="tabpanel" aria-labelledby="tab-certificates" data-panel="certificates" hidden>
                <div class="grid grid-3">
                    @forelse ($certificates as $item)
                        @php $image = \App\Support\Media::url($item->image); @endphp
                        <article class="glass card cert-card">
                            @if ($image)
                                <a class="cert-shot" href="{{ $image }}" target="_blank" rel="noopener noreferrer">
                                    <img src="{{ $image }}" alt="Sertifikat {{ $item->title }}">
                                </a>
                            @else
                                <div class="cert-mark" aria-hidden="true">{{ \Illuminate\Support\Str::of($item->issuer ?: $item->title)->substr(0, 1) }}</div>
                            @endif
                            <p class="meta">{{ $item->issuer }} @if($item->issued_on) · {{ $item->issued_on }} @endif</p>
                            <h3>{{ $item->title }}</h3>
                            <p>{{ $item->description }}</p>
                            @if ($item->credential_url)
                                <a class="btn btn-line" href="{{ $item->credential_url }}" target="_blank" rel="noopener noreferrer">Lihat kredensial</a>
                            @endif
                        </article>
                    @empty
                        <p class="muted">Belum ada sertifikat.</p>
                    @endforelse
                </div>
            </div>

            <div class="tab-panel" id="panel-achievements" role="tabpanel" aria-labelledby="tab-achievements" data-panel="achievements" hidden>
                <div class="grid grid-2">
                    @forelse ($achievements as $item)
                        <article class="glass card">
                            <span class="index">{{ $item->year }}</span>
                            <h3>{{ $item->title }}</h3>
                            @if ($item->subtitle)<p class="meta">{{ $item->subtitle }}</p>@endif
                            <p>{{ $item->description }}</p>
                        </article>
                    @empty
                        <p class="muted">Belum ada pencapaian.</p>
                    @endforelse
                </div>
            </div>

            <div class="tab-panel" id="panel-stack" role="tabpanel" aria-labelledby="tab-stack" data-panel="stack" hidden>
                @if ($techItems->isEmpty())
                    <p class="muted">Tech stack belum diisi.</p>
                @else
                    <div class="stack-grid">
                        @foreach ($techItems->sortBy('sort_order') as $item)
                            <article class="stack-card">
                                @include('partials.tech-mark', ['name' => $item->name])
                                <span>{{ $item->name }}</span>
                            </article>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="section" id="jejak">
        <div class="container">
            <div class="section-head">
                <p class="pill">{{ $site['experience_kicker'] ?? 'Jejak' }}</p>
                <h2>{{ $site['experience_title'] }}</h2>
            </div>
            <ol class="timeline">
                @foreach ($experiences as $item)
                    <li class="glass">
                        <span>{{ $item->period }}</span>
                        <div>
                            <h3>{{ $item->title }}</h3>
                            <p class="meta">{{ $item->organization }}</p>
                            <p>{{ $item->description }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </section>

    <section class="section" id="layanan">
        <div class="container">
            <div class="section-head">
                <p class="pill">{{ $site['services_kicker'] ?? 'Layanan' }}</p>
                <h2>{{ $site['services_title'] }}</h2>
            </div>
            <div class="grid grid-2">
                @foreach ($services as $service)
                    @php
                        $parts = preg_split("/\r?\n\s*\r?\n/", trim((string) $service->description), 2);
                        $lead = trim($parts[0] ?? '');
                        $items = preg_split("/\r?\n/", trim($parts[1] ?? '')) ?: [];
                    @endphp
                    <article class="glass card service-card grid-item">
                        <span class="index">{{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
                        <h3>{{ $service->title }}</h3>
                        @if ($lead !== '')<p>{{ $lead }}</p>@endif
                        @if (collect($items)->filter(fn ($item) => trim($item) !== '')->isNotEmpty())
                            <ul class="service-list">
                                @foreach ($items as $item)
                                    @if (trim($item) !== '')<li>{{ $item }}</li>@endif
                                @endforeach
                            </ul>
                        @endif
                    </article>
                @endforeach
            </div>
            @if (!empty($site['services_close']))
                <p class="close-line">{{ $site['services_close'] }}</p>
            @endif
            <div class="section-head method-head">
                <p class="pill">{{ $site['method_kicker'] ?? 'How we work' }}</p>
                <h2>{{ $site['method_title'] }}</h2>
                @if (!empty($site['method_body']))<p class="lede">{{ $site['method_body'] }}</p>@endif
            </div>
            <div class="grid grid-2">
                @foreach ($methods as $block)
                    <article class="glass card">
                        <span class="index">{{ $block->eyebrow }} — {{ $block->title }}</span>
                        @include('partials.block-copy', ['body' => $block->body])
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section" id="prinsip">
        <div class="container">
            <div class="section-head">
                <p class="pill">{{ $site['principle_kicker'] ?? 'Why StepUp Project' }}</p>
                <h2>{{ $site['principle_title'] }}</h2>
                @if (!empty($site['principle_body']))<p class="lede">{{ $site['principle_body'] }}</p>@endif
            </div>
            <div class="grid grid-2">
                @foreach ($principles as $block)
                    <article class="glass card principle">
                        <span class="index">{{ $block->eyebrow }}</span>
                        <h3>{{ $block->title }}</h3>
                        @include('partials.block-copy', ['body' => $block->body])
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section" id="tentang">
        <div class="container about glass">
            <p class="pill">{{ $site['about_kicker'] ?? 'Tentang' }}</p>
            <h2>{{ $site['about_title'] }}</h2>
            <p class="meta">{{ $site['about_role'] }}</p>
            <div class="prose">{!! nl2br(e($site['about_body'] ?? '')) !!}</div>
        </div>
    </section>

    <section class="section" id="faq">
        <div class="container narrow">
            <div class="section-head">
                <p class="pill">{{ $site['faq_kicker'] ?? 'Pertanyaan' }}</p>
                <h2>{{ $site['faq_title'] }}</h2>
            </div>
            @foreach ($faqs as $faq)
                <details class="faq glass">
                    <summary>{{ $faq->question }}</summary>
                    <p>{{ $faq->answer }}</p>
                </details>
            @endforeach
        </div>
    </section>

    <section class="section" id="kontak">
        <div class="container contact-grid">
            <div>
                <p class="pill">{{ $site['contact_kicker'] ?? 'Kontak' }}</p>
                <h2>{{ $site['cta_title'] }}</h2>
                <p class="lede">{{ $site['cta_subtitle'] }}</p>
            </div>
            <form class="glass form" method="post" action="{{ route('inquiries.store') }}">
                @csrf
                @if ($errors->any())
                    <div class="alert" id="form-errors" role="alert" tabindex="-1">
                        <p>Periksa isian berikut.</p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="hp" aria-hidden="true">
                    <label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label>
                </div>
                <label for="name">Nama</label>
                <input id="name" name="name" value="{{ old('name') }}" required autocomplete="name" aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}">
                <label for="contact">WhatsApp atau email</label>
                <input id="contact" name="contact" value="{{ old('contact') }}" required autocomplete="tel" aria-invalid="{{ $errors->has('contact') ? 'true' : 'false' }}">
                <label for="topic">Kebutuhan</label>
                <input id="topic" name="topic" value="{{ old('topic') }}" placeholder="Website, dasbor, atau otomasi">
                <label for="message">Konteks singkat</label>
                <textarea id="message" name="message" required aria-invalid="{{ $errors->has('message') ? 'true' : 'false' }}">{{ old('message') }}</textarea>
                <button class="btn btn-light" type="submit">Kirim dan buka WhatsApp</button>
            </form>
        </div>
    </section>
@endsection

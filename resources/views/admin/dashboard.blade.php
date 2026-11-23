@extends('layouts.admin')

@section('title', 'Ringkasan')

@section('content')
    <header class="page-head">
        <h1>Ringkasan</h1>
        <p class="muted">Isi landing diubah dari sini. Situs publik membaca data yang berstatus tayang.</p>
    </header>
    @if ($defaultPassword || $placeholderWa)
        <div class="alert" role="status">
            @if ($defaultPassword)
                <p>Kata sandi masih bawaan. Ganti di Pengaturan.</p>
            @endif
            @if ($placeholderWa)
                <p>Nomor WhatsApp masih contoh. Ganti sebelum situs dibuka publik.</p>
            @endif
        </div>
    @endif
    <div class="metric-grid">
        <div class="glass metric"><strong>{{ $counts['visits'] }}</strong><span>Kunjungan hari ini</span></div>
        <a class="glass metric" href="{{ route('admin.projects.index') }}"><strong>{{ $counts['projects'] }}</strong><span>Proyek</span></a>
        <a class="glass metric" href="{{ route('admin.certificates.index') }}"><strong>{{ $counts['certificates'] }}</strong><span>Sertifikat</span></a>
        <a class="glass metric" href="{{ route('admin.tech-items.index') }}"><strong>{{ $counts['tech'] }}</strong><span>Tech stack</span></a>
        <a class="glass metric" href="{{ route('admin.inquiries.index') }}"><strong>{{ $counts['inquiries'] }}</strong><span>Pesan</span></a>
    </div>
    <div class="split">
        <section class="glass panel">
            <h2>Proyek terbaru</h2>
            <ul>
                @forelse ($projects as $project)
                    <li><a href="{{ route('admin.projects.edit', $project) }}">{{ $project->title }}</a></li>
                @empty
                    <li>Belum ada proyek.</li>
                @endforelse
            </ul>
        </section>
        <section class="glass panel">
            <h2>Pesan terbaru</h2>
            <ul>
                @forelse ($inquiries as $inquiry)
                    <li>{{ $inquiry->name }} — {{ $inquiry->topic ?: 'Tanpa topik' }}</li>
                @empty
                    <li>Belum ada pesan.</li>
                @endforelse
            </ul>
        </section>
    </div>
@endsection

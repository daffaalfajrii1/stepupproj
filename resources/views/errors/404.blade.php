@extends('layouts.site')

@section('title', 'Halaman tidak ditemukan — '.($site['site_name'] ?? 'StepUp'))
@section('description', 'Alamat ini tidak ada di StepUp Project.')
@section('robots', 'noindex, follow')

@section('content')
    <section class="section missing">
        <div class="container">
            <p class="pill">404</p>
            <h1>Halaman ini tidak ada.</h1>
            <p class="lede">Tautan mungkin sudah berpindah, atau alamatnya salah ketik.</p>
            <div class="stack-actions">
                <a class="btn btn-light" href="{{ route('home') }}">Ke beranda</a>
                <a class="btn btn-line" href="{{ route('portfolio.index') }}">Lihat portofolio</a>
            </div>
        </div>
    </section>
@endsection

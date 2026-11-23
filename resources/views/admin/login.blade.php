@extends('layouts.admin')

@section('title', 'Masuk')

@section('content')
    <main class="login-wrap">
        <form class="glass login-card" method="post" action="{{ route('admin.login.store') }}">
            @csrf
            <a class="logo" href="{{ route('home') }}">
                @if ($mark = \App\Support\Media::url($site['logo'] ?? null))
                    <img src="{{ $mark }}" alt="{{ $site['site_name'] ?? 'StepUp' }}">
                @else
                    {{ $site['site_name'] ?? 'StepUp' }}
                @endif
            </a>
            <h1>Masuk</h1>
            @if ($errors->any())
                <div class="alert" role="alert" tabindex="-1">{{ $errors->first() }}</div>
            @endif
            <label for="email">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username" autofocus>
            <label for="password">Kata sandi</label>
            <input id="password" name="password" type="password" required autocomplete="current-password">
            <label class="check"><input type="checkbox" name="remember" value="1"> Ingat sesi ini</label>
            <button class="btn btn-light" type="submit">Masuk</button>
        </form>
    </main>
@endsection

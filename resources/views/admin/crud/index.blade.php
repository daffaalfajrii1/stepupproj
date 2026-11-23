@extends('layouts.admin')

@section('title', $title)

@section('content')
    <header class="page-head row">
        <div>
            <h1>{{ $title }}</h1>
            @if ($hint)<p class="muted">{{ $hint }}</p>@endif
        </div>
        <a class="btn btn-light" href="{{ route($route.'.create') }}">Tambah</a>
    </header>
    <div class="table-wrap glass">
        <table>
            <thead>
                <tr>
                    @foreach ($columns as $column)
                        <th>{{ $column['label'] }}</th>
                    @endforeach
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        @foreach ($columns as $column)
                            <td>
                                @if (($column['type'] ?? '') === 'image')
                                    @if ($item->{$column['key']})
                                        <img class="thumb" src="{{ \App\Support\Media::url($item->{$column['key']}) }}" alt="">
                                    @endif
                                @elseif (($column['type'] ?? '') === 'bool')
                                    <span class="status {{ $item->{$column['key']} ? 'on' : 'off' }}">{{ $item->{$column['key']} ? 'Tayang' : 'Draf' }}</span>
                                @else
                                    {{ $item->{$column['key']} }}
                                @endif
                            </td>
                        @endforeach
                        <td class="actions">
                            <a href="{{ route($route.'.edit', $item) }}">Ubah</a>
                            <form method="post" action="{{ route($route.'.destroy', $item) }}" onsubmit="return confirm('Hapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="{{ count($columns) + 1 }}">Belum ada data.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

@extends('layouts.admin')

@section('title', 'Pesan')

@section('content')
    <header class="page-head">
        <h1>Pesan masuk</h1>
        <p class="muted">Tersimpan saat pengunjung mengirim form kontak, lalu diarahkan ke WhatsApp.</p>
    </header>
    <div class="table-wrap glass">
        <table>
            <thead>
                <tr><th>Nama</th><th>Kontak</th><th>Topik</th><th>Pesan</th><th></th></tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->contact }}</td>
                        <td>{{ $item->topic }}</td>
                        <td>{{ $item->message }}</td>
                        <td>
                            <form method="post" action="{{ route('admin.inquiries.destroy', $item) }}" onsubmit="return confirm('Hapus pesan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">Belum ada pesan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

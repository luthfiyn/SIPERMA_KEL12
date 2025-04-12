@extends('layouts.app') {{-- Ganti jika pakai layout lain --}}

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Data Pengaduan (Join Kategori & Respon)</h2>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Judul</th>
                <th>Isi Pengaduan</th>
                <th>Kategori</th>
                <th>Respon</th>
                <th>Status</th>
                <th>Tanggal Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
                <tr>
                <td>{{ $item->judul }}</td>
                <td>{{ $item->isi }}</td>
                <td>{{ $item->nama_kategori }}</td>
                <td>{{ $item->respon ?? 'Belum direspon' }}</td>
                <td>{{ ucfirst($item->status) }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>

                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data pengaduan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

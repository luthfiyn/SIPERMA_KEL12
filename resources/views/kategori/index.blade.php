@extends('layouts.app')

@section('title', 'Daftar Kategori')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Daftar Kategori Pengaduan</h4>
        <a href="{{ route('kategori.create') }}" class="btn btn-success">+ Tambah Kategori</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Dibuat Pada</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kategories as $kategori)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kategori->nama_kategori }}</td>
                    <td>{{ $kategori->created_at->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">Belum ada kategori.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Pengaduan yang Dihapus')

@section('content')
<div class="container">
    <h2 class="my-4">Pengaduan yang Dihapus (Soft Delete)</h2>

    @if($pengaduan->isEmpty())
        <div class="alert alert-info">Tidak ada pengaduan yang dihapus.</div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Oleh</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pengaduan as $item)
                    <tr>
                        <td>{{ $item->judul }}</td>
                        <td>{{ $item->kategori->nama_kategori }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <!-- Button for permanently deleting the complaint -->
                            <form action="{{ route('pengaduan.forceDelete', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengaduan ini secara permanen?')">Hapus Permanen</button>
                            </form>
                            <!-- Button for restoring the soft-deleted complaint -->
                            <form action="{{ route('pengaduan.restore', $item->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success btn-sm">Pulihkan</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $pengaduan->links() }}
    @endif
</div>
@endsection

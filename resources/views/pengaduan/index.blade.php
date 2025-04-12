@extends('layouts.app')

@section('title', 'Daftar Pengaduan')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Daftar Pengaduan</h2>
            
            <!-- Search Form -->
            <form action="{{ route('pengaduan.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Cari pengaduan..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Cari
                </button>
            </form>

            @if(auth()->user()->role === 'masyarakat')
                <a href="{{ route('pengaduan.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Buat Pengaduan Baru
                </a>
            @endif

            @if(auth()->user()->role === 'admin')
                <!-- Button to view soft-deleted (trash) complaints -->
                <a href="{{ route('pengaduan.trash') }}" class="btn btn-danger">
                    <i class="fas fa-trash-alt"></i> Lihat Trash
                </a>
            @endif
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pengaduan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ Str::limit($item->judul, 30) }}</td>
                                    <td>{{ $item->kategori->nama_kategori }}</td>
                                    <td>
                                        <span class="badge bg-{{ $item->status === 'selesai' ? 'success' : ($item->status === 'diproses' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('pengaduan.show', $item->id) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if(auth()->user()->role === 'admin' || (auth()->user()->role === 'masyarakat' && $item->status === 'dikirim'))
                                            <a href="{{ route('pengaduan.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        @endif
                                        @if(auth()->user()->role === 'admin')
                                            <form action="{{ route('pengaduan.destroy', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data pengaduan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $pengaduan->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Tambahkan script khusus jika diperlukan
</script>
@endsection

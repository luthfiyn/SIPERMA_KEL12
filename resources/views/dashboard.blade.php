@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Dashboard Pelayanan Masyarakat</h2>
        <hr>
    </div>
</div>

<div class="row">
    @if(auth()->check() && auth()->user()->role === 'admin')
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Pengaduan</h5>
                    <p class="card-text display-4">{{ $totalPengaduan }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Pengaduan Selesai</h5>
                    <p class="card-text display-4">{{ $pengaduanSelesai }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Pengaduan Diproses</h5>
                    <p class="card-text display-4">{{ $pengaduanDiproses }}</p>
                </div>
            </div>
        </div>
    @elseif(auth()->check() && auth()->user()->role === 'masyarakat')
        <div class="col-md-6 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Pengaduan Saya</h5>
                    <p class="card-text display-4">{{ $pengaduanSaya }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Pengaduan Selesai</h5>
                    <p class="card-text display-4">{{ $pengaduanSelesai }}</p>
                </div>
            </div>
        </div>
    @endif
</div>

@if(auth()->check() && auth()->user()->role === 'admin')
    <div class="row mt-4">
        <div class="col-md-12">
            <h4>Pengaduan Terbaru</h4>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Judul</th>
                            <th>Pengadu</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pengaduanTerbaru as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ Str::limit($item->judul, 30) }}</td>
                                <td>{{ $item->user->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->status === 'selesai' ? 'success' : ($item->status === 'diproses' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('pengaduan.show', $item->id) }}" class="btn btn-sm btn-info">Detail</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif
@endsection

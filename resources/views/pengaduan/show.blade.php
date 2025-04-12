@extends('layouts.app')

@section('title', 'Detail Pengaduan')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Detail Pengaduan</span>
                <span class="badge bg-{{ $pengaduan->status === 'selesai' ? 'success' : ($pengaduan->status === 'diproses' ? 'warning' : 'secondary') }}">
                    {{ ucfirst($pengaduan->status) }}
                </span>
            </div>
            
            <div class="card-body">
                <div class="mb-4">
                    <h4>{{ $pengaduan->judul }}</h4>
                    <div class="text-muted small">
                        Oleh: {{ $pengaduan->user->name }} | 
                        Kategori: {{ $pengaduan->kategori->nama_kategori }} | 
                        Tanggal: {{ $pengaduan->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>
                
                <div class="mb-4 p-3 bg-light rounded">
                    {!! nl2br(e($pengaduan->isi)) !!}
                </div>
                
                @if($pengaduan->status !== 'dikirim' && $pengaduan->respon->count() > 0)
                    <hr>
                    <h5>Respon:</h5>
                    @foreach($pengaduan->respon as $respon)
                        <div class="card mb-3">
                            <div class="card-header bg-light d-flex justify-content-between">
                                <span>{{ $respon->user->name }}</span>
                                <span class="text-muted small">{{ $respon->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="card-body">
                                {!! nl2br(e($respon->isi_respon)) !!}
                            </div>
                        </div>
                    @endforeach
                @endif
                
                @if(auth()->user()->role === 'admin' && $pengaduan->status !== 'selesai')
                    <hr>
                    <form action="{{ route('pengaduan.respon', $pengaduan->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="isi_respon" class="form-label">Berikan Respon</label>
                            <textarea class="form-control" id="isi_respon" name="isi_respon" rows="3" required></textarea>
                        </div>
                        <div class="d-flex justify-content-between">
                            <div>
                                <select class="form-select" name="status" required>
                                    <option value="diproses" {{ $pengaduan->status === 'diproses' ? 'selected' : '' }}>Proses</option>
                                    <option value="selesai">Selesai</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Kirim Respon</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
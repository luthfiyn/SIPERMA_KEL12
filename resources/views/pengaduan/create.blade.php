@extends('layouts.app')

@section('title', 'Buat Pengaduan Baru')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header">Form Pengaduan</div>
            
            <div class="card-body">
                <form action="{{ route('pengaduan.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="judul" class="form-label">Judul Pengaduan</label>
                        <input type="text" class="form-control @error('judul') is-invalid @enderror" id="judul" name="judul" value="{{ old('judul') }}" required>
                        @error('judul')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="kategori_id" class="form-label">Kategori</label>
                        <select class="form-select @error('kategori_id') is-invalid @enderror" id="kategori_id" name="kategori_id" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($kategori as $item)
    <option value="{{ $item->id }}" {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
        {{ $item->nama_kategori }}
    </option>
@endforeach

                        </select>
                        @error('kategori_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="isi" class="form-label">Isi Pengaduan</label>
                        <textarea class="form-control @error('isi') is-invalid @enderror" id="isi" name="isi" rows="5" required>{{ old('isi') }}</textarea>
                        @error('isi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Kirim Pengaduan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
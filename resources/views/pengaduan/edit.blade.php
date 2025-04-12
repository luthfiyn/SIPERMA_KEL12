@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Edit Pengaduan</h1>

        <!-- Form to edit the complaint -->
        <form action="{{ route('pengaduan.update', $pengaduan->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Kategori Select -->
            <div class="mb-3">
                <label for="kategori_id" class="form-label">Kategori</label>
                <select name="kategori_id" id="kategori_id" class="form-select" required>
                    @foreach($kategori as $kat)
                        <option value="{{ $kat->id }}" {{ $kat->id == $pengaduan->kategori_id ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Judul Input -->
            <div class="mb-3">
                <label for="judul" class="form-label">Judul</label>
                <input type="text" name="judul" id="judul" class="form-control" value="{{ old('judul', $pengaduan->judul) }}" required>
            </div>

            <!-- Isi Textarea -->
            <div class="mb-3">
                <label for="isi" class="form-label">Isi</label>
                <textarea name="isi" id="isi" class="form-control" required>{{ old('isi', $pengaduan->isi) }}</textarea>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary">Update</button>
        </form>

        <!-- Back Link -->
        <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary mt-3">Back to list</a>
    </div>
@endsection
s
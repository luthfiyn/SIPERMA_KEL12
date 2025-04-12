@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Daftar Akun Masyarakat</h2>

    <form action="{{ route('register') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Alamat Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Kata Sandi</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Daftar</button>
        @if(session('success'))
            <script>
                alert('{{ session('success') }}');
            </script>
        @endif

        <a href="{{ route('login') }}" class="btn btn-link">Sudah punya akun? Login</a>
    </form>
</div>
@endsection

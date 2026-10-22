@extends('layouts.app')

@section('title', 'Daftar Akun')

@section('content')
    <div class="card auth-card">
        <h1>Buat akun siswa</h1>
        <p class="muted">Daftar untuk mengakses layanan perpustakaan.</p>

        <form action="{{ route('register.store') }}" method="POST">
            @csrf

            <div class="field">
                <label for="name">Nama lengkap</label>
                <input
                    class="form-control"
                    id="name"
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    maxlength="100"
                    autocomplete="name"
                    required
                >
                @error('name') <div class="errors">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input
                    class="form-control"
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    required
                >
                @error('email') <div class="errors">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label for="password">Password (minimal 8 karakter)</label>
                <input
                    class="form-control"
                    id="password"
                    type="password"
                    name="password"
                    autocomplete="new-password"
                    required
                >
                @error('password') <div class="errors">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label for="password_confirmation">Konfirmasi password</label>
                <input
                    class="form-control"
                    id="password_confirmation"
                    type="password"
                    name="password_confirmation"
                    autocomplete="new-password"
                    required
                >
            </div>

            <button class="btn" type="submit">Buat akun</button>
        </form>
    </div>
@endsection
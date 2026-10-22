@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
    <div class="card auth-card">
        <h1>Selamat datang kembali</h1>
        <p class="muted">Masuk untuk melanjutkan peminjaman buku.</p>

        <form action="{{ route('login.store') }}" method="POST">
            @csrf

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
                <label for="password">Password</label>
                <input
                    class="form-control"
                    id="password"
                    type="password"
                    name="password"
                    autocomplete="current-password"
                    required
                >
                @error('password') <div class="errors">{{ $message }}</div> @enderror
            </div>

            <button class="btn" type="submit">Masuk</button>
        </form>

        <p class="muted">
            Belum punya akun?
            <a href="{{ route('register') }}"><strong>Daftar di sini</strong></a>
        </p>
    </div>
@endsection
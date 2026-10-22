@extends('layouts.app')

@section('title', 'Ajukan Peminjaman')

@section('content')
    <div class="card">
        <h1>Ajukan peminjaman</h1>

        <p class="muted">
            Tentukan sendiri berapa hari kamu ingin meminjam buku.
            Tanggal resmi ditetapkan admin setelah permohonan diperiksa.
        </p>

        <h3>Daftar buku</h3>

        <ul>
            @foreach($books as $book)
                <li>
                    {{ $book->title }} × {{ $cart[$book->id] }}
                </li>
            @endforeach
        </ul>

        <form action="{{ route('borrowings.store') }}" method="POST">
            @csrf

            <div class="field">
                <label for="duration_days">
                    Durasi peminjaman (hari)
                </label>

                <input
                    class="form-control"
                    type="number"
                    name="duration_days"
                    id="duration_days"
                    min="1"
                    max="365"
                    step="1"
                    value="{{ old('duration_days') }}"
                    placeholder="Contoh: 10"
                    required
                >

                <small class="muted">
                    Masukkan jumlah hari antara 1 sampai 365 hari.
                </small>

                @error('duration_days')
                    <div class="errors">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn" type="submit">
                Kirim permohonan
            </button>

            <a class="btn btn-outline"
               href="{{ route('cart.index') }}">
                Kembali ke keranjang
            </a>
        </form>
    </div>
@endsection

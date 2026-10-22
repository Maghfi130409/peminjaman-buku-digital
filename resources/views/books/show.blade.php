@extends('layouts.app')

@section('title', $book->title)

@section('content')
    <div class="card">
        <div class="form-row">
            <div>
                @if($book->cover)
                    <img
                        src="{{ asset('storage/' . $book->cover) }}"
                        alt="Sampul {{ $book->title }}"
                        style="width:100%;max-width:350px;border-radius:14px"
                    >
                @else
                    <div class="cover-placeholder" style="max-width:350px">📚</div>
                @endif
            </div>

            <div>
                <div class="muted">Detail koleksi</div>
                <h1>{{ $book->title }}</h1>
                <p>Penulis: <strong>{{ $book->author }}</strong></p>
                <p>Penerbit: {{ $book->publisher ?: 'Belum dicantumkan' }}</p>
                <p>ISBN: {{ $book->isbn ?: 'Belum dicantumkan' }}</p>
                <p>Stok tersedia: <strong>{{ $book->stock }}</strong></p>

                <p>{{ $book->description ?: 'Belum ada deskripsi buku.' }}</p>

                @auth
                    @if($book->stock > 0)
                        <form action="{{ route('cart.add', $book) }}" method="POST" class="stack">
                            @csrf
                            <div class="field">
                                <label for="quantity">Jumlah buku</label>
                                <input
                                    class="form-control"
                                    id="quantity"
                                    type="number"
                                    name="quantity"
                                    min="1"
                                    max="{{ min(10, $book->stock) }}"
                                    value="1"
                                    required
                                >
                            </div>
                            <button class="btn" type="submit">Tambah ke keranjang</button>
                        </form>
                    @else
                        <p class="muted">Stok sedang habis.</p>
                    @endif
                @else
                    <a class="btn" href="{{ route('login') }}">Masuk untuk meminjam</a>
                @endauth
            </div>
        </div>
    </div>
@endsection
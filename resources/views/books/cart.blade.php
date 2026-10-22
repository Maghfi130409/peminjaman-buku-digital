@extends('layouts.app')

@section('title', 'Keranjang Peminjaman')

@section('content')
    <div class="section-head">
        <div>
            <h1>Keranjang Peminjaman</h1>
            <p class="muted">Periksa koleksi dan jumlah buku sebelum mengajukan.</p>
        </div>
    </div>

    @if(count($cart) && $books->count())
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Stok</th>
                        <th>Jumlah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                        <tr>
                            <td>
                                <strong>{{ $book->title }}</strong>
                                <div class="muted">{{ $book->author }}</div>
                            </td>
                            <td>{{ $book->stock }}</td>
                            <td>
                                <form action="{{ route('cart.update', $book) }}" method="POST" class="actions">
                                    @csrf
                                    @method('PATCH')
                                    <input
                                        class="form-control"
                                        style="width:90px"
                                        type="number"
                                        name="quantity"
                                        min="0"
                                        max="{{ min(10, $book->stock) }}"
                                        value="{{ $cart[$book->id] }}"
                                        required
                                    >
                                    <button class="btn btn-light" type="submit">Perbarui</button>
                                </form>
                                <div class="muted small">Isi 0 untuk menghapus.</div>
                            </td>
                            <td>
                                <form action="{{ route('cart.remove', $book) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top:20px">
            <a class="btn btn-outline" href="{{ route('books.index') }}">Tambah buku lain</a>
            <a class="btn" href="{{ route('checkout') }}">Lanjutkan peminjaman</a>
        </div>
    @else
        <div class="card">
            <h2>Keranjang masih kosong</h2>
            <p class="muted">Pilih buku dari katalog untuk memulai peminjaman.</p>
            <a href="{{ route('books.index') }}" class="btn">Lihat katalog</a>
        </div>
    @endif
@endsection
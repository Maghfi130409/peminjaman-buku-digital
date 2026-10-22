@extends('layouts.app')

@section('title', 'Kelola Buku')

@section('content')
    <div class="section-head">
        <div>
            <h1>Kelola Buku</h1>
            <p class="muted">Tambah, edit, dan pantau stok buku perpustakaan.</p>
        </div>

        <a class="btn" href="{{ route('admin.books.create') }}">+ Tambah buku</a>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($books as $book)
                    <tr>
                        <td>
                            <strong>{{ $book->title }}</strong>
                            <div class="muted">{{ $book->isbn ?: 'Tanpa ISBN' }}</div>
                        </td>
                        <td>{{ $book->author }}</td>
                        <td>{{ $book->stock }}</td>
                        <td>
                            <div class="actions">
                                <a
                                    class="btn btn-light"
                                    href="{{ route('admin.books.edit', $book) }}"
                                >
                                    Edit
                                </a>

                                <form
                                    action="{{ route('admin.books.destroy', $book) }}"
                                    method="POST"
                                    onsubmit="return confirm('Hapus buku ini?')"
                                >
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4">Belum ada buku di database.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">{{ $books->links() }}</div>
@endsection
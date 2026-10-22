@extends('layouts.app')

@section('title', $book->exists ? 'Edit Buku' : 'Tambah Buku')

@section('content')
    <div class="card">
        <h1>{{ $book->exists ? 'Edit Buku' : 'Tambah Buku Baru' }}</h1>

        <form
            action="{{ $book->exists
                ? route('admin.books.update', $book)
                : route('admin.books.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            @if($book->exists)
                @method('PUT')
            @endif

            <div class="field">
                <label for="title">Judul buku</label>
                <input
                    class="form-control"
                    id="title"
                    name="title"
                    value="{{ old('title', $book->title) }}"
                    required
                    maxlength="255"
                >
                @error('title') <div class="errors">{{ $message }}</div> @enderror
            </div>

            <div class="form-row">
                <div class="field">
                    <label for="author">Penulis</label>
                    <input
                        class="form-control"
                        id="author"
                        name="author"
                        value="{{ old('author', $book->author) }}"
                        required
                    >
                    @error('author') <div class="errors">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="publisher">Penerbit</label>
                    <input
                        class="form-control"
                        id="publisher"
                        name="publisher"
                        value="{{ old('publisher', $book->publisher) }}"
                    >
                    @error('publisher') <div class="errors">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="field">
                    <label for="isbn">ISBN</label>
                    <input
                        class="form-control"
                        id="isbn"
                        name="isbn"
                        value="{{ old('isbn', $book->isbn) }}"
                    >
                    @error('isbn') <div class="errors">{{ $message }}</div> @enderror
                </div>

                <div class="field">
                    <label for="stock">Stok</label>
                    <input
                        class="form-control"
                        id="stock"
                        type="number"
                        name="stock"
                        value="{{ old('stock', $book->stock ?? 0) }}"
                        min="0"
                        required
                    >
                    @error('stock') <div class="errors">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="field">
                <label for="description">Deskripsi</label>
                <textarea
                    class="form-control"
                    id="description"
                    name="description"
                    rows="5"
                >{{ old('description', $book->description) }}</textarea>
                @error('description') <div class="errors">{{ $message }}</div> @enderror
            </div>

            <div class="field">
                <label for="cover">Sampul buku (JPG, PNG, WEBP, maksimal 2 MB)</label>
                <input
                    class="form-control"
                    id="cover"
                    type="file"
                    name="cover"
                    accept=".jpg,.jpeg,.png,.webp"
                >
                @error('cover') <div class="errors">{{ $message }}</div> @enderror

                @if($book->cover)
                    <p class="muted">Sampul saat ini:</p>
                    <img
                        src="{{ asset('storage/' . $book->cover) }}"
                        alt="Sampul saat ini"
                        style="width:120px;border-radius:10px"
                    >
                @endif
            </div>

            <button class="btn" type="submit">Simpan buku</button>
            <a class="btn btn-outline" href="{{ route('admin.books.index') }}">
                Batal
            </a>
        </form>
    </div>
@endsection
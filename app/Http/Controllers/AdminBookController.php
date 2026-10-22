<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminBookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->paginate(15);

        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $book = new Book();

        return view('admin.books.form', compact('book'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'isbn' => ['nullable', 'string', 'max:255', 'unique:books,isbn'],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0', 'max:100000'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        Book::create($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $buku)
    {
        $book = $buku;

        return view('admin.books.form', compact('book'));
    }

    public function update(Request $request, Book $buku)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'publisher' => ['nullable', 'string', 'max:255'],
            'isbn' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('books', 'isbn')->ignore($buku->id),
            ],
            'description' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0', 'max:100000'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('cover')) {
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }

            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Book $buku)
    {
        if ($buku->borrowingDetails()->exists()) {
            return back()->withErrors([
                'book' => 'Buku memiliki riwayat peminjaman dan tidak dapat dihapus.',
            ]);
        }

        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }

        $buku->delete();

        return back()->with('success', 'Buku berhasil dihapus.');
    }
}
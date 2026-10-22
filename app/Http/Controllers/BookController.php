<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class BookController extends Controller
{
    /**
     * Menampilkan katalog buku, pencarian, dan filter kategori.
     */
    public function index(Request $request)
    {
        $query = Book::query();

        // Pencarian berdasarkan judul atau penulis.
        if ($request->filled('q')) {
            $keyword = $request->input('q');

            $query->where(function ($builder) use ($keyword) {
                $builder->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('author', 'like', '%' . $keyword . '%');
            });
        }

        // Siapkan daftar kategori.
        $categories = collect();
        $totalCategories = 0;

        // Filter kategori hanya digunakan jika kolom tersedia.
        if (Schema::hasColumn('books', 'category')) {
            $categories = Book::query()
                ->whereNotNull('category')
                ->where('category', '!=', '')
                ->distinct()
                ->orderBy('category')
                ->pluck('category');

            $totalCategories = $categories->count();

            if ($request->filled('category')) {
                $query->where('category', $request->input('category'));
            }
        }

        // Ambil buku dan pertahankan parameter pencarian saat berpindah halaman.
        $books = $query->latest()
            ->paginate(12)
            ->withQueryString();

        // Statistik katalog.
        $totalBooks = Book::count();

        $availableBooks = Book::where('stock', '>', 0)->count();

        return view('books.index', compact(
            'books',
            'categories',
            'totalBooks',
            'availableBooks',
            'totalCategories'
        ));
    }

    /**
     * Menampilkan detail buku.
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    /**
     * Menampilkan keranjang.
     */
    public function cart()
    {
        $cart = session('cart', []);

        $books = Book::whereIn('id', array_keys($cart))->get();

        return view('books.cart', compact('cart', 'books'));
    }

    /**
     * Menambahkan buku ke keranjang.
     */
    public function addToCart(Request $request, Book $book)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
        ]);

        if ($book->stock < 1) {
            return back()->withErrors([
                'cart' => 'Stok buku sedang habis.',
            ]);
        }

        $cart = session('cart', []);
        $quantity = ($cart[$book->id] ?? 0) + $data['quantity'];

        if ($quantity > 10 || $quantity > $book->stock) {
            return back()->withErrors([
                'cart' => 'Jumlah melebihi stok atau batas maksimal 10 buku per judul.',
            ]);
        }

        $cart[$book->id] = $quantity;

        session(['cart' => $cart]);

        return redirect()->route('cart.index')
            ->with('success', 'Buku ditambahkan ke keranjang.');
    }

    /**
     * Memperbarui jumlah buku dalam keranjang.
     */
    public function updateCart(Request $request, Book $book)
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:10'],
        ]);

        $cart = session('cart', []);

        if ($data['quantity'] === 0) {
            unset($cart[$book->id]);
        } else {
            if ($data['quantity'] > $book->stock) {
                return back()->withErrors([
                    'cart' => 'Jumlah melebihi stok buku yang tersedia.',
                ]);
            }

            $cart[$book->id] = $data['quantity'];
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    /**
     * Menghapus buku dari keranjang.
     */
    public function removeFromCart(Book $book)
    {
        $cart = session('cart', []);

        unset($cart[$book->id]);

        session(['cart' => $cart]);

        return back()->with('success', 'Buku dihapus dari keranjang.');
    }
}

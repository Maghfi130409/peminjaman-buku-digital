<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class BorrowingController extends Controller
{
    public function checkout()
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->withErrors([
                    'cart' => 'Keranjang masih kosong.'
                ]);
        }

        $books = Book::whereIn('id', array_keys($cart))->get();

        if ($books->count() !== count($cart)) {
            return redirect()->route('cart.index')
                ->withErrors([
                    'cart' => 'Ada buku yang tidak lagi tersedia.'
                ]);
        }

        return view('borrowings.checkout', compact('books', 'cart'));
    }

    public function store(Request $request)
    {
        // User bebas menentukan durasi antara 1 sampai 365 hari.
        $data = $request->validate([
            'duration_days' => [
                'required',
                'integer',
                'min:1',
                'max:365',
            ],
        ], [
            'duration_days.required' =>
                'Durasi peminjaman wajib diisi.',
            'duration_days.integer' =>
                'Durasi peminjaman harus berupa bilangan bulat.',
            'duration_days.min' =>
                'Durasi peminjaman minimal 1 hari.',
            'duration_days.max' =>
                'Durasi peminjaman maksimal 365 hari.',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->withErrors([
                    'cart' => 'Keranjang masih kosong.'
                ]);
        }

        try {
            $borrowing = DB::transaction(function () use (
                $cart,
                $data,
                $request
            ) {
                $ids = array_map('intval', array_keys($cart));
                sort($ids);

                $books = Book::whereIn('id', $ids)
                    ->orderBy('id')
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                if ($books->count() !== count($cart)) {
                    throw new RuntimeException(
                        'Ada buku yang tidak tersedia.'
                    );
                }

                foreach ($cart as $id => $quantity) {
                    $book = $books->get((int) $id);

                    if (
                        ! $book ||
                        ! is_numeric($quantity) ||
                        (int) $quantity < 1 ||
                        (int) $quantity > 10 ||
                        (int) $quantity > $book->stock
                    ) {
                        throw new RuntimeException(
                            'Stok atau jumlah buku tidak valid. Periksa keranjang.'
                        );
                    }
                }

                $borrowing = Borrowing::create([
                    'user_id' => $request->user()->id,
                    'duration_days' => (int) $data['duration_days'],
                    'requested_date' => now()->toDateString(),
                    'status' => 'pending',
                ]);

                foreach ($cart as $id => $quantity) {
                    $borrowing->details()->create([
                        'book_id' => (int) $id,
                        'quantity' => (int) $quantity,
                    ]);
                }

                return $borrowing;
            });
        } catch (RuntimeException $e) {
            return redirect()->route('cart.index')
                ->withErrors([
                    'cart' => $e->getMessage()
                ]);
        }

        session()->forget('cart');

        return redirect()
            ->route('borrowings.show', $borrowing)
            ->with(
                'success',
                'Permohonan peminjaman berhasil dikirim.'
            );
    }

    public function index(Request $request)
    {
        $borrowings = Borrowing::where(
            'user_id',
            $request->user()->id
        )
            ->with('details.book')
            ->latest()
            ->paginate(10);

        return view('borrowings.index', compact('borrowings'));
    }

    public function show(Request $request, Borrowing $borrowing)
    {
        abort_unless(
            $borrowing->user_id === $request->user()->id,
            403
        );

        $borrowing->load('details.book');

        return view('borrowings.show', compact('borrowing'));
    }
}

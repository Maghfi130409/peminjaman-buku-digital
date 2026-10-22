<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AdminBorrowingController extends Controller
{
    /**
     * Menampilkan seluruh riwayat peminjaman di panel admin.
     */
    public function index()
    {
        $borrowings = Borrowing::with('user', 'details.book')
            ->latest()
            ->paginate(15);

        return view('admin.borrowings.index', compact('borrowings'));
    }

    /**
     * Menyetujui permohonan peminjaman.
     */
    public function approve(Request $request, Borrowing $borrowing)
    {
        $data = $request->validate([
            'approved_at_date' => ['required', 'date'],
            'due_date' => [
                'required',
                'date',
                'after_or_equal:approved_at_date',
            ],
            'admin_note' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::transaction(function () use ($borrowing, $data) {
            $locked = Borrowing::whereKey($borrowing->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($locked->status !== 'pending') {
                throw ValidationException::withMessages([
                    'status' => 'Permohonan ini sudah diproses.',
                ]);
            }

            $details = $locked->details()
                ->orderBy('book_id')
                ->get();

            if ($details->isEmpty()) {
                throw ValidationException::withMessages([
                    'books' => 'Permohonan tidak memiliki detail buku.',
                ]);
            }

            $ids = $details->pluck('book_id')->unique()->all();
            sort($ids);

            $books = Book::whereIn('id', $ids)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($details as $detail) {
                $book = $books->get($detail->book_id);

                if (! $book || $book->stock < $detail->quantity) {
                    throw ValidationException::withMessages([
                        'stock' => 'Stok salah satu buku tidak mencukupi.',
                    ]);
                }
            }

            foreach ($details as $detail) {
                $books->get($detail->book_id)
                    ->decrement('stock', $detail->quantity);
            }

            $locked->update([
                'status' => 'approved',
                'approved_at_date' => $data['approved_at_date'],
                'due_date' => $data['due_date'],
                'admin_note' => $data['admin_note'] ?? null,
            ]);
        });

        return back()->with(
            'success',
            'Peminjaman berhasil disetujui.'
        );
    }

    /**
     * Menolak permohonan peminjaman.
     */
    public function reject(Request $request, Borrowing $borrowing)
    {
        $data = $request->validate([
            'admin_note' => ['required', 'string', 'max:1000'],
        ]);

        $updated = Borrowing::whereKey($borrowing->id)
            ->where('status', 'pending')
            ->update([
                'status' => 'rejected',
                'admin_note' => $data['admin_note'],
                'updated_at' => now(),
            ]);

        if (! $updated) {
            return back()->withErrors([
                'status' => 'Permohonan sudah diproses sebelumnya.',
            ]);
        }

        return back()->with(
            'success',
            'Permohonan berhasil ditolak.'
        );
    }

    /**
     * Mencatat pengembalian buku dan menambahkan stok kembali.
     */
    public function markReturned(Borrowing $borrowing)
    {
        DB::transaction(function () use ($borrowing) {
            $locked = Borrowing::whereKey($borrowing->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($locked->status !== 'approved') {
                throw ValidationException::withMessages([
                    'status' => 'Hanya peminjaman yang disetujui dapat dikembalikan.',
                ]);
            }

            $details = $locked->details()
                ->orderBy('book_id')
                ->get();

            if ($details->isEmpty()) {
                throw ValidationException::withMessages([
                    'books' => 'Peminjaman tidak memiliki detail buku.',
                ]);
            }

            $ids = $details->pluck('book_id')->unique()->all();
            sort($ids);

            $books = Book::whereIn('id', $ids)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            foreach ($details as $detail) {
                if (! $books->has($detail->book_id)) {
                    throw ValidationException::withMessages([
                        'books' => 'Data buku tidak ditemukan.',
                    ]);
                }
            }

            foreach ($details as $detail) {
                $books->get($detail->book_id)
                    ->increment('stock', $detail->quantity);
            }

            $locked->update([
                'status' => 'returned',
                'returned_at_date' => now()->toDateString(),
            ]);
        });

        return back()->with(
            'success',
            'Pengembalian berhasil dicatat.'
        );
    }

    /**
     * Menghapus riwayat peminjaman yang sudah selesai atau ditolak.
     */
    public function destroy(Borrowing $borrowing)
    {
        DB::transaction(function () use ($borrowing) {
            $locked = Borrowing::whereKey($borrowing->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (! in_array(
                $locked->status,
                ['returned', 'rejected'],
                true
            )) {
                throw ValidationException::withMessages([
                    'status' => 'Hanya riwayat berstatus returned atau rejected yang dapat dihapus.',
                ]);
            }

            // Hapus detail agar tidak terkendala foreign key,
            // jika database tidak menghapus detail secara cascade.
            $locked->details()->delete();

            // Stok tidak diubah saat menghapus riwayat.
            $locked->delete();
        });

        return redirect()
            ->route('admin.borrowings.index')
            ->with('success', 'Riwayat peminjaman berhasil dihapus.');
    }
}

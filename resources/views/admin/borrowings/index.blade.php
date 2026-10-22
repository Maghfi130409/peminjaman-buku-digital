
@extends('layouts.app')

@section('title', 'Panel Admin')

@section('content')
    {{-- Notifikasi sukses --}}
    @if(session('success'))
        <div class="card" style="margin-bottom: 20px; border-left: 5px solid #238653;">
            <p style="margin: 0; color: #238653;">
                {{ session('success') }}
            </p>
        </div>
    @endif

    {{-- Notifikasi error --}}
    @if($errors->any())
        <div class="card" style="margin-bottom: 20px; border-left: 5px solid #dc3545;">
            <ul style="margin: 0; color: #dc3545;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="section-head">
        <div>
            <h1>Panel Admin</h1>
            <p class="muted">
                Periksa permohonan, catat pengembalian, dan kelola riwayat peminjaman.
            </p>
        </div>

        <a href="{{ route('admin.books.index') }}" class="btn">
            Kelola buku
        </a>
    </div>

    @forelse($borrowings as $borrowing)
        <div class="card" style="margin-bottom: 20px;">

            {{-- Informasi peminjam --}}
            <div class="section-head">
                <div>
                    <h2>Permohonan #{{ $borrowing->id }}</h2>

                    <div class="muted">
                        {{ $borrowing->user?->name ?? 'Pengguna tidak tersedia' }}
                        ·
                        {{ $borrowing->user?->email ?? '-' }}
                    </div>
                </div>

                <span class="badge badge-{{ $borrowing->status }}">
                    {{ ucfirst($borrowing->status) }}
                </span>
            </div>

            {{-- Informasi durasi --}}
            <p>
                Durasi diminta:
                <strong>{{ $borrowing->duration_days }} hari</strong>
                · Diajukan:
                {{ $borrowing->requested_date?->format('d-m-Y') ?? '-' }}
            </p>

            {{-- Daftar buku --}}
            <h3>Daftar buku</h3>

            <ul>
                @forelse($borrowing->details as $detail)
                    <li>
                        {{ $detail->book?->title ?? 'Buku tidak tersedia' }}
                        × {{ $detail->quantity }}
                    </li>
                @empty
                    <li class="muted">Tidak ada detail buku.</li>
                @endforelse
            </ul>

            {{-- Catatan admin --}}
            @if($borrowing->admin_note)
                <p>
                    <strong>Catatan admin:</strong>
                    {{ $borrowing->admin_note }}
                </p>
            @endif

            {{-- Permohonan menunggu persetujuan --}}
            @if($borrowing->status === 'pending')
                <div class="form-row">
                    <div>
                        <h3>Setujui permohonan</h3>

                        <form
                            action="{{ route('admin.borrowings.approve', $borrowing) }}"
                            method="POST"
                        >
                            @csrf

                            <div class="field">
                                <label for="approved_at_date_{{ $borrowing->id }}">
                                    Tanggal peminjaman resmi
                                </label>

                                <input
                                    class="form-control"
                                    type="date"
                                    id="approved_at_date_{{ $borrowing->id }}"
                                    name="approved_at_date"
                                    value="{{ now()->toDateString() }}"
                                    required
                                >
                            </div>

                            <div class="field">
                                <label for="due_date_{{ $borrowing->id }}">
                                    Tanggal jatuh tempo resmi
                                </label>

                                <input
                                    class="form-control"
                                    type="date"
                                    id="due_date_{{ $borrowing->id }}"
                                    name="due_date"
                                    value="{{ now()->addDays($borrowing->duration_days)->toDateString() }}"
                                    min="{{ now()->toDateString() }}"
                                    required
                                >
                            </div>

                            <div class="field">
                                <label for="approve_note_{{ $borrowing->id }}">
                                    Catatan admin (opsional)
                                </label>

                                <textarea
                                    class="form-control"
                                    id="approve_note_{{ $borrowing->id }}"
                                    name="admin_note"
                                    rows="2"
                                    maxlength="1000"
                                ></textarea>
                            </div>

                            <button class="btn" type="submit">
                                Setujui
                            </button>
                        </form>
                    </div>

                    <div>
                        <h3>Tolak permohonan</h3>

                        <form
                            action="{{ route('admin.borrowings.reject', $borrowing) }}"
                            method="POST"
                        >
                            @csrf

                            <div class="field">
                                <label for="reject_note_{{ $borrowing->id }}">
                                    Alasan penolakan
                                </label>

                                <textarea
                                    class="form-control"
                                    id="reject_note_{{ $borrowing->id }}"
                                    name="admin_note"
                                    rows="3"
                                    required
                                    maxlength="1000"
                                    placeholder="Tuliskan alasan penolakan."
                                ></textarea>
                            </div>

                            <button class="btn btn-danger" type="submit">
                                Tolak permohonan
                            </button>
                        </form>
                    </div>
                </div>

            {{-- Peminjaman sudah disetujui --}}
            @elseif($borrowing->status === 'approved')
                <p>
                    Tanggal peminjaman:
                    {{ $borrowing->approved_at_date?->format('d-m-Y') ?? '-' }}
                </p>

                <p>
                    Jatuh tempo:
                    {{ $borrowing->due_date?->format('d-m-Y') ?? '-' }}
                </p>

                <form
                    action="{{ route('admin.borrowings.return', $borrowing) }}"
                    method="POST"
                    onsubmit="return confirm('Catat semua buku dalam transaksi ini sebagai sudah dikembalikan?')"
                >
                    @csrf

                    <button class="btn" type="submit">
                        Catat pengembalian
                    </button>
                </form>

            {{-- Peminjaman sudah dikembalikan --}}
            @elseif($borrowing->status === 'returned')
                <p class="muted">
                    Sudah dikembalikan pada
                    {{ $borrowing->returned_at_date?->format('d-m-Y') ?? '-' }}.
                </p>
            @endif

            {{-- Tombol hapus untuk riwayat selesai atau ditolak --}}
            @if(in_array($borrowing->status, ['returned', 'rejected'], true))
                <div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid #e5e7eb;">
                    <p class="muted" style="margin-bottom: 12px;">
                        Riwayat ini sudah selesai atau ditolak.
                    </p>

                    <form
                        action="{{ route('admin.borrowings.destroy', $borrowing) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus riwayat peminjaman #{{ $borrowing->id }}? Data yang dihapus tidak dapat dikembalikan.')"
                    >
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger" type="submit">
                            Hapus Riwayat
                        </button>
                    </form>
                </div>
            @endif

        </div>
    @empty
        <div class="card">
            <h3>Belum ada riwayat peminjaman</h3>
            <p class="muted">
                Permohonan peminjaman akan muncul di halaman ini.
            </p>
        </div>
    @endforelse

    {{-- Navigasi halaman --}}
    <div class="pagination">
        {{ $borrowings->links() }}
    </div>
@endsection

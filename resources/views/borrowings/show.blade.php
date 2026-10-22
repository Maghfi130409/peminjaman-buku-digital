@extends('layouts.app')

@section('title', 'Detail Peminjaman')

@section('content')
    <div class="card">
        <h1>Permohonan #{{ $borrowing->id }}</h1>

        <p>
            Status:
            <span class="badge badge-{{ $borrowing->status }}">
                {{ ucfirst($borrowing->status) }}
            </span>
        </p>

        <p>Durasi diminta: <strong>{{ $borrowing->duration_days }} hari</strong></p>
        <p>Tanggal permohonan: {{ $borrowing->requested_date?->format('d-m-Y') ?? '-' }}</p>
        <p>Tanggal peminjaman resmi: {{ $borrowing->approved_at_date?->format('d-m-Y') ?? '-' }}</p>
        <p>Tanggal jatuh tempo: {{ $borrowing->due_date?->format('d-m-Y') ?? '-' }}</p>
        <p>Tanggal pengembalian: {{ $borrowing->returned_at_date?->format('d-m-Y') ?? '-' }}</p>

        @if($borrowing->admin_note)
            <div class="alert">
                <strong>Catatan admin:</strong>
                {{ $borrowing->admin_note }}
            </div>
        @endif

        <h3>Buku yang diajukan</h3>
        <ul>
            @foreach($borrowing->details as $detail)
                <li>
                    {{ $detail->book?->title ?? 'Buku tidak tersedia' }}
                    × {{ $detail->quantity }}
                </li>
            @endforeach
        </ul>

        <a class="btn btn-outline" href="{{ route('borrowings.index') }}">
            Kembali ke riwayat
        </a>
    </div>
@endsection
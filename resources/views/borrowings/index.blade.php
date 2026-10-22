@extends('layouts.app')

@section('title', 'Peminjaman Saya')

@section('content')
    <div class="section-head">
        <h1>Riwayat Peminjaman</h1>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal permohonan</th>
                    <th>Buku</th>
                    <th>Durasi</th>
                    <th>Status</th>
                    <th>Jatuh tempo</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($borrowings as $borrowing)
                    <tr>
                        <td>#{{ $borrowing->id }}</td>
                        <td>{{ $borrowing->requested_date?->format('d-m-Y') ?? '-' }}</td>
                        <td>
                            @foreach($borrowing->details as $detail)
                                <div>
                                    {{ $detail->book?->title ?? 'Buku tidak tersedia' }}
                                    × {{ $detail->quantity }}
                                </div>
                            @endforeach
                        </td>
                        <td>{{ $borrowing->duration_days }} hari</td>
                        <td>
                            <span class="badge badge-{{ $borrowing->status }}">
                                {{ ucfirst($borrowing->status) }}
                            </span>
                        </td>
                        <td>{{ $borrowing->due_date?->format('d-m-Y') ?? '-' }}</td>
                        <td>
                            <a class="btn btn-light"
                               href="{{ route('borrowings.show', $borrowing) }}">
                                Lihat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7">Belum ada riwayat peminjaman.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination">{{ $borrowings->links() }}</div>
@endsection
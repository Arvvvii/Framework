@extends('layouts.resepsionis.main')

@section('title', 'Temu Dokter')

@section('content')
<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Temu Dokter</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Temu Dokter</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                {{-- Antrian Hari Ini --}}
                <div class="card mb-3">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class="card-title mb-0">Antrian Hari Ini</h3>
                        <span class="badge bg-primary">{{ isset($antrianHariIni) ? $antrianHariIni->count() : 0 }} Pasien</span>
                    </div>
                    <div class="card-body">
                        @if(isset($antrianHariIni) && $antrianHariIni->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>No. Urut</th>
                                        <th>Waktu</th>
                                        <th>Nama Hewan</th>
                                        <th>Pemilik</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($antrianHariIni as $row)
                                        <tr>
                                            <td class="fw-bold">{{ $row->no_urut ?? '-' }}</td>
                                            <td>
                                                {{ $row->waktu_daftar?->format('d-m-Y H:i') ?? 'N/A' }}<br>
                                                <small class="text-muted">{{ $row->waktu_daftar?->diffForHumans() }}</small>
                                            </td>
                                            <td>{{ $row->pet->nama ?? 'N/A' }}</td>
                                            <td>{{ $row->pet->pemilik->user->nama ?? 'N/A' }}</td>
                                            <td>
                                                @php
                                                    $statusLabel = [
                                                        '1' => ['Menunggu', 'warning'],
                                                        '2' => ['Selesai', 'success'],
                                                        '3' => ['Batal', 'danger'],
                                                    ];
                                                    $status = $row->status;
                                                    $label = $statusLabel[$status][0] ?? 'Tidak Diketahui';
                                                    $class = $statusLabel[$status][1] ?? 'secondary';
                                                @endphp
                                                <span class="badge bg-{{ $class }}">{{ $label }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                            <div class="text-muted">Belum ada antrian untuk hari ini.</div>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Temu Dokter</h3>
                        <div class="card-tools">
                            <a href="{{ route('resepsionis.temudokter.create') }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-plus"></i> Buat Janji Temu
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <table id="temuDokterTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>No. Urut</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th>Nama Hewan</th>
                                    <th>Pemilik</th>
                                    <th>Ras Hewan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($temuDokter as $td)
                                    <tr>
                                        <td>{{ $td->idreservasi_dokter ?? $td->idtemu_dokter ?? 'N/A' }}</td>
                                        <td>{{ $td->no_urut ?? '-' }}</td>
                                        <td>
                                            {{ $td->waktu_daftar?->format('d-m-Y H:i') ?? 'N/A' }}<br>
                                            <small class="text-muted">{{ $td->waktu_daftar?->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            @php
                                                $statusLabel = [
                                                    '1' => ['Menunggu', 'warning'],
                                                    '2' => ['Selesai', 'success'],
                                                    '3' => ['Batal', 'danger'],
                                                ];
                                                $status = $td->status;
                                                $label = $statusLabel[$status][0] ?? 'Tidak Diketahui';
                                                $class = $statusLabel[$status][1] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $class }}">{{ $label }}</span>
                                        </td>
                                        <td>{{ $td->pet->nama ?? 'N/A' }}</td>
                                        <td>{{ $td->pet->pemilik->user->nama ?? 'N/A' }}</td>
                                        <td>{{ $td->pet->rasHewan->nama_ras ?? 'N/A' }}</td>
                                        <td>
                                            <form action="{{ route('resepsionis.temudokter.destroy', $td->idtemu_dokter ?? $td->idreservasi_dokter) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin membatalkan janji temu ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-times"></i> Cancel
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data temu dokter.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#temuDokterTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            pageLength: 25,
            order: [[0, 'desc']]
        });
    });
</script>
@endpush

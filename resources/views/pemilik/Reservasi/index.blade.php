@extends('layouts.pemilik.main')

@section('title', 'Reservasi')

@section('content')
<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Daftar Reservasi</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Reservasi</li>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Riwayat Reservasi Temu Dokter</h3>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <table id="reservasiTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Waktu Reservasi</th>
                                    <th>Nama Pet</th>
                                    <th>Ras Hewan</th>
                                    <th>Anamnesa/Keluhan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reservasi as $res)
                                    <tr>
                                        <td>{{ $res->idreservasi_dokter }}</td>
                                        <td>
                                            {{ $res->waktu_daftar?->format('d-m-Y H:i') ?? 'N/A' }}<br>
                                            <small class="text-muted">{{ $res->waktu_daftar?->diffForHumans() }}</small>
                                        </td>
                                        <td>{{ $res->pet->nama ?? 'N/A' }}</td>
                                        <td>{{ $res->pet->rasHewan->nama_ras ?? 'N/A' }}</td>
                                        <td>
                                            @if($res->rekamMedis->count() > 0)
                                                {{ \Illuminate\Support\Str::limit($res->rekamMedis->first()->anamnesa ?? '-', 50) }}
                                            @else
                                                <span class="text-muted">Belum diperiksa</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($res->rekamMedis->count() > 0)
                                                <span class="badge bg-primary">Sudah Diperiksa</span>
                                            @elseif($res->waktu_daftar && $res->waktu_daftar->isPast())
                                                <span class="badge bg-secondary">Selesai</span>
                                            @else
                                                <span class="badge bg-success">Akan Datang</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data reservasi.</td>
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
        @if($reservasi->count() > 0)
        $('#reservasiTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            pageLength: 25,
            order: [[0, 'desc']]
        });
        @endif
    });
</script>
@endpush

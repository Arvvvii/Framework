@extends('layouts.dokter.main')

@section('title', 'Rekam Medis')

@push('head')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
@endpush

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Rekam Medis: {{ $petData->nama }}</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dokter.pasien.index') }}">Data Pasien</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Rekam Medis</li>
                </ol>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-8">
                <div class="alert alert-secondary mb-2 p-2">
                    <strong>Nama Hewan:</strong> {{ $petData->nama }}<br>
                    <strong>Pemilik:</strong> {{ $petData->pemilik->user->nama ?? '-' }}<br>
                    <strong>Jenis:</strong> {{ $petData->rasHewan->jenisHewan->nama_jenis_hewan ?? '-' }}<br>
                    <strong>Ras:</strong> {{ $petData->rasHewan->nama_ras ?? '-' }}
                </div>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Rekam Medis</h3>
                        <!-- Card tools kosong, CRUD detail rekam medis diatur di halaman detail -->
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table id="rekamMedisTable" class="table table-bordered table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">ID</th>
                                        <th>Tanggal</th>
                                        <th>Anamnesa</th>
                                        <th>Temuan Klinis</th>
                                        <th>Diagnosa</th>
                                        <th>Dokter Pemeriksa</th>
                                        <th>Nama Hewan</th>
                                        <th>Pemilik</th>
                                        <th>Ras Hewan</th>
                                        <th style="width: 80px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rekamMedis as $rm)
                                        <tr>
                                            <td>{{ $rm->idrekam_medis }}</td>
                                            <td>
                                                <strong>{{ $rm->created_at?->format('d-m-Y H:i:s') ?? 'N/A' }}</strong>
                                                <br><small class="text-muted">{{ $rm->created_at?->diffForHumans() }}</small>
                                            </td>
                                            <td>{{ Str::limit($rm->anamnesa, 50) }}</td>
                                            <td>{{ Str::limit($rm->temuan_klinis, 50) }}</td>
                                            <td>{{ Str::limit($rm->diagnosa, 50) }}</td>
                                            <td>{{ $rm->roleUser->user->nama ?? 'N/A' }}</td>
                                            <td>{{ $rm->temuDokter->pet->nama ?? 'N/A' }}</td>
                                            <td>{{ $rm->temuDokter->pet->pemilik->user->nama ?? 'N/A' }}</td>
                                            <td>{{ $rm->temuDokter->pet->rasHewan->nama_ras ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('dokter.rekammedis.detail.index', [$rm->idrekam_medis, 'pet' => $petData->idpet]) }}" class="btn btn-info btn-sm" title="Lihat daftar detail">
                                                    <i class="bi bi-list-ul"></i>
                                                </a>
                                                <a href="{{ route('dokter.rekammedis.detail.create', [$rm->idrekam_medis, 'pet' => $petData->idpet]) }}" class="btn btn-primary btn-sm" title="Tambah detail">
                                                    <i class="bi bi-plus-lg"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">
                                                <i class="bi bi-inbox"></i> Tidak ada data rekam medis
                                            </td>
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
</div>
@endsection

@push('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    $('#rekamMedisTable').DataTable({
        responsive: true,
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Data tidak ditemukan",
            info: "Menampilkan halaman _PAGE_ dari _PAGES_",
            infoEmpty: "Tidak ada data yang tersedia",
            infoFiltered: "(difilter dari _MAX_ total data)",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        },
        pageLength: 10,
        order: [[0, 'desc']] // Sort by ID descending
    });
});
</script>
@endpush

@extends('layouts.perawat.main')

@section('title', 'Rekam Medis')

@section('content')
<!-- Content Header (Page header) -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Rekam Medis</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Rekam Medis</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- /.content-header -->
                                        

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Rekam Medis</h3>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <table id="rekamMedisTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tanggal</th>
                                    <th>Nama Hewan</th>
                                    <th>Pemilik</th>
                                    <th>Ras</th>
                                    <th>Anamnesa</th>
                                    <th>Temuan Klinis</th>
                                    <th>Diagnosa</th>
                                    <th>Dokter</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($newReservations) && $newReservations->count())
                                    <tr class="table-info">
                                        <td colspan="10"><strong>Reservasi Baru (belum punya rekam medis)</strong></td>
                                    </tr>
                                    @foreach($newReservations as $r)
                                        <tr>
                                            <td>-</td>
                                            <td>{{ $r->waktu_daftar?->format('d-m-Y H:i') ?? 'N/A' }}</td>
                                            <td>{{ $r->pet->nama ?? 'N/A' }}</td>
                                            <td>{{ $r->pet->pemilik->user->nama ?? 'N/A' }}</td>
                                            <td>{{ $r->pet->rasHewan->nama_ras ?? 'N/A' }}</td>
                                            <td colspan="3">-</td>
                                            <td>-</td>
                                            <td>
                                                <a href="{{ route('perawat.rekammedis.create') }}?idreservasi={{ $r->idreservasi_dokter }}" class="btn btn-sm btn-primary">Buat Rekam Medis</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                @forelse($rekamMedis as $rekam)
                                    <tr>
                                        <td>{{ $rekam->idrekam_medis }}</td>
                                        <td>
                                            {{ $rekam->created_at?->format('d-m-Y H:i') ?? 'N/A' }}<br>
                                            <small class="text-muted">{{ $rekam->created_at?->diffForHumans() }}</small>
                                        </td>
                                        <td>{{ $rekam->temuDokter->pet->nama ?? 'N/A' }}</td>
                                        <td>{{ $rekam->temuDokter->pet->pemilik->user->nama ?? 'N/A' }}</td>
                                        <td>{{ $rekam->temuDokter->pet->rasHewan->nama_ras ?? 'N/A' }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($rekam->anamnesa, 50) }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($rekam->temuan_klinis, 50) }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($rekam->diagnosa, 50) }}</td>
                                        <td>{{ $rekam->roleUser->user->nama ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('perawat.rekammedis.show', $rekam->idrekam_medis) }}" class="btn btn-sm btn-info">Lihat</a>
                                            <a href="{{ route('perawat.rekammedis.edit', $rekam->idrekam_medis) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <form action="{{ route('perawat.rekammedis.destroy', $rekam->idrekam_medis) }}" method="POST" style="display:inline" onsubmit="return confirm('Hapus rekam medis ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Tidak ada data rekam medis.</td>
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
<!-- /.content -->
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#rekamMedisTable').DataTable({
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

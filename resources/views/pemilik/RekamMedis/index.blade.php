@extends('layouts.pemilik.main')

@section('title', 'Rekam Medis')

@section('content')
<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Rekam Medis</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Rekam Medis</li>
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
                        <h3 class="card-title">Riwayat Rekam Medis Pet Saya</h3>
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
                                    <th>Nama Pet</th>
                                    <th>Anamnesa</th>
                                    <th>Temuan Klinis</th>
                                    <th>Diagnosa</th>
                                    <th>Dokter Pemeriksa</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($rekamMedis as $rm)
                                    <tr>
                                        <td>{{ $rm->idrekam_medis }}</td>
                                        <td>
                                            {{ $rm->created_at?->format('d-m-Y H:i') ?? 'N/A' }}<br>
                                            <small class="text-muted">{{ $rm->created_at?->diffForHumans() }}</small>
                                        </td>
                                        <td>{{ $rm->temuDokter->pet->nama ?? 'N/A' }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($rm->anamnesa, 50) }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($rm->temuan_klinis, 50) }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($rm->diagnosa, 50) }}</td>
                                        <td>{{ $rm->roleUser->user->nama ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data rekam medis.</td>
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
        @if($rekamMedis->count() > 0)
        $('#rekamMedisTable').DataTable({
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

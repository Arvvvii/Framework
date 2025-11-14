@extends('layouts.admin.main')

@section('title', 'Rekam Medis')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Rekam Medis</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Rekam Medis</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Rekam Medis</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.rekammedis.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> Tambah Rekam Medis
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th style="width: 120px">Tanggal</th>
                                        <th>Anamnesa</th>
                                        <th>Temuan Klinis</th>
                                        <th>Diagnosa</th>
                                        <th>Dokter</th>
                                        <th>Pet</th>
                                        <th>Pemilik</th>
                                        <th>Ras</th>
                                        <th style="width: 120px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($rekamMedis as $rekam)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <small>{{ $rekam->created_at ? \Carbon\Carbon::parse($rekam->created_at)->format('d M Y') : 'N/A' }}</small>
                                            </td>
                                            <td>{{ Str::limit($rekam->anamnesa, 30) }}</td>
                                            <td>{{ Str::limit($rekam->temuan_klinis, 30) }}</td>
                                            <td>{{ Str::limit($rekam->diagnosa, 30) }}</td>
                                            <td>{{ $rekam->dokter_nama ?? 'N/A' }}</td>
                                            <td>{{ $rekam->pet_nama ?? 'N/A' }}</td>
                                            <td>{{ $rekam->pemilik_id ?? 'N/A' }}</td>
                                            <td>{{ $rekam->ras_hewan_nama ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('admin.rekammedis.edit', $rekam->idrekam_medis) }}" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('admin.rekammedis.destroy', $rekam->idrekam_medis) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
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
</div>
@endsection

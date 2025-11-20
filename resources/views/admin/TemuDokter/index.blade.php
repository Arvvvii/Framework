@extends('layouts.admin.main')

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
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Temu Dokter</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.temudokter.create') }}" class="btn btn-warning btn-sm">
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
                                    <th>Tanggal</th>
                                    <th>Keluhan</th>
                                    <th>Nama Hewan</th>
                                    <th>Pemilik</th>
                                    <th>Ras Hewan</th>
                                    <th style="width: 120px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($temuDokter as $td)
                                    <tr class="align-middle">
                                        <td>{{ $td->idreservasi_dokter ?? $td->idtemu_dokter ?? 'N/A' }}</td>
                                        <td>
                                            {{ $td->waktu_daftar?->format('d-m-Y H:i') ?? 'N/A' }}<br>
                                            <small class="text-muted">{{ $td->waktu_daftar?->diffForHumans() }}</small>
                                        </td>
                                        <td>{{ \Illuminate\Support\Str::limit($td->keluhan ?? 'N/A', 50) }}</td>
                                        <td>{{ $td->pet->nama ?? 'N/A' }}</td>
                                        <td>{{ $td->pet->pemilik->user->nama ?? 'N/A' }}</td>
                                        <td>{{ $td->pet->rasHewan->nama_ras ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('admin.temudokter.edit', $td->idreservasi_dokter ?? $td->idtemu_dokter) }}" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('admin.temudokter.destroy', $td->idreservasi_dokter ?? $td->idtemu_dokter) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus janji temu ini?');">
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

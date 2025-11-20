@extends('layouts.perawat.main')

@section('title', 'Tindakan Terapi')

@section('content')
<!-- Content Header (Page header) -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Tindakan Terapi</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tindakan Terapi</li>
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
                        <h3 class="card-title">Daftar Kode Tindakan Terapi</h3>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <table id="tindakanTerapiTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Kode</th>
                                    <th>Deskripsi</th>
                                    <th>Kategori</th>
                                    <th>Kategori Klinis</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kodeTindakanTerapis as $kode)
                                    <tr>
                                        <td>{{ $kode->idkode_tindakan_terapi }}</td>
                                        <td><span class="badge bg-info">{{ $kode->kode }}</span></td>
                                        <td>{{ $kode->deskripsi_tindakan_terapi }}</td>
                                        <td>{{ $kode->kategori->nama_kategori ?? 'N/A' }}</td>
                                        <td>{{ $kode->kategoriKlinis->nama_kategori_klinis ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data tindakan terapi.</td>
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
        $('#tindakanTerapiTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            pageLength: 25,
            order: [[1, 'asc']]
        });
    });
</script>
@endpush

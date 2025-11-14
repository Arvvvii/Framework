@extends('layouts.admin.main')

@section('title', 'Tindakan Terapi')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Tindakan Terapi</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tindakan Terapi</li>
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
                        <h3 class="card-title">Daftar Kode Tindakan Terapi</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.kodeterapi.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> Tambah Kode Terapi
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
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th style="width: 100px">Kode</th>
                                        <th>Deskripsi</th>
                                        <th>Kategori</th>
                                        <th>Kategori Klinis</th>
                                        <th style="width: 150px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($kodeterapis as $kt)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td><span class="badge bg-info">{{ $kt->kode }}</span></td>
                                            <td>{{ $kt->deskripsi_tindakan_terapi }}</td>
                                            <td>{{ $kt->nama_kategori ?? 'N/A' }}</td>
                                            <td>{{ $kt->nama_kategori_klinis ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('admin.kodeterapi.edit', $kt->idkode_tindakan_terapi) }}" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('admin.kodeterapi.destroy', $kt->idkode_tindakan_terapi) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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
                                            <td colspan="6" class="text-center">Tidak ada data kode tindakan terapi.</td>
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

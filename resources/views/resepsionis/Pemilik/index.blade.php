@extends('layouts.resepsionis.main')

@section('title', 'Pemilik')

@section('content')
<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Pemilik</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pemilik</li>
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
                        <h3 class="card-title">Daftar Pemilik</h3>
                        <div class="card-tools">
                            <a href="{{ route('resepsionis.pemilik.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Tambah Pemilik
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

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <table id="pemilikTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>No. WhatsApp</th>
                                    <th>Email</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pemilik as $p)
                                    <tr>
                                        <td>{{ $p->idpemilik }}</td>
                                        <td>{{ $p->user->nama ?? '-' }}</td>
                                        <td>{{ $p->alamat }}</td>
                                        <td>{{ $p->no_wa ?? '-' }}</td>
                                        <td>{{ $p->user->email ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('resepsionis.pemilik.edit', $p->idpemilik) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('resepsionis.pemilik.destroy', $p->idpemilik) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus pemilik ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data pemilik.</td>
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
        $('#pemilikTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
            },
            pageLength: 25
        });
    });
</script>
@endpush

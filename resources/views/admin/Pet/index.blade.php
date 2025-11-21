@extends('layouts.admin.main')

@section('title', 'Data Pet')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Pet</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Pet</li>
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
                        <h3 class="card-title">Daftar Pet</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.pet.create') }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> Tambah Pet
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
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Warna Tanda</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Pemilik</th>
                                        <th>Ras Hewan</th>
                                        <th style="width: 150px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pets as $pet)
                                        <tr class="align-middle">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $pet->nama }}</td>
                                            <td>{{ $pet->tanggal_lahir ?? 'N/A' }}</td>
                                            <td>{{ $pet->warna_tanda }}</td>
                                            <td>
                                                @php
                                                    $jk = strtolower(trim($pet->jenis_kelamin ?? ''));
                                                @endphp

                                                @if(in_array($jk, ['l','j','m','male','jantan','j']))
                                                    <span class="badge bg-primary">Jantan</span>
                                                @elseif(in_array($jk, ['p','b','f','female','betina','b']))
                                                    <span class="badge bg-danger">Betina</span>
                                                @elseif($jk !== '')
                                                    @php $first = substr($jk, 0, 1); @endphp
                                                    @if(in_array($first, ['l','j','m']))
                                                        <span class="badge bg-primary">Jantan</span>
                                                    @elseif(in_array($first, ['p','b','f']))
                                                        <span class="badge bg-danger">Betina</span>
                                                    @else
                                                        <span class="badge bg-secondary">-</span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-secondary">-</span>
                                                @endif
                                            </td>
                                            <td>{{ $pet->pemilik_nama ?? 'N/A' }}</td>
                                            <td>{{ $pet->nama_ras ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('admin.pet.edit', $pet->idpet) }}" class="btn btn-sm btn-warning">
                                                    <i class="bi bi-pencil-square"></i>
                                                </a>
                                                <form action="{{ route('admin.pet.destroy', $pet->idpet) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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
                                            <td colspan="8" class="text-center">Tidak ada data pet.</td>
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

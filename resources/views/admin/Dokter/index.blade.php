@extends('layouts.admin.main')

@section('title', 'Data Dokter')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Dokter</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.dokter.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Dokter
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

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama User</th>
                                    <th>Alamat</th>
                                    <th>No HP</th>
                                    <th>Bidang Dokter</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dokters as $index => $dokter)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $dokter->user->nama ?? '-' }}</td>
                                        <td>{{ $dokter->alamat }}</td>
                                        <td>{{ $dokter->no_hp }}</td>
                                        <td>{{ $dokter->bidang_dokter }}</td>
                                        <td>{{ $dokter->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        <td>
                                            <a href="{{ route('admin.dokter.edit', $dokter->id_dokter) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.dokter.destroy', $dokter->id_dokter) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data dokter</td>
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

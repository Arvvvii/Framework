@extends('layouts.admin.main')

@section('title', 'Data Perawat')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Perawat</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.perawat.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah Perawat
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
                                    <th>Pendidikan</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($perawats as $index => $perawat)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $perawat->user->nama ?? '-' }}</td>
                                        <td>{{ $perawat->alamat }}</td>
                                        <td>{{ $perawat->no_hp }}</td>
                                        <td>{{ $perawat->pendidikan }}</td>
                                        <td>{{ $perawat->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                        <td>
                                            <a href="{{ route('admin.perawat.edit', $perawat->id_perawat) }}" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('admin.perawat.destroy', $perawat->id_perawat) }}" method="POST" style="display:inline-block;">
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
                                        <td colspan="7" class="text-center">Tidak ada data perawat</td>
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

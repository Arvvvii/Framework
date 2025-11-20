@extends('layouts.perawat.main')

@section('title', 'Data Pasien')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Data Pasien</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Data Pasien</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Daftar Pasien</h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Hewan</th>
                            <th>Pemilik</th>
                            <th>Jenis</th>
                            <th>Ras</th>
                            <th style="width: 120px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pasiens as $pasien)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pasien->nama }}</td>
                            <td>{{ $pasien->pemilik->user->nama ?? '-' }}</td>
                            <td>{{ $pasien->rasHewan->jenisHewan->nama_jenis_hewan ?? '-' }}</td>
                            <td>{{ $pasien->rasHewan->nama_ras ?? '-' }}</td>
                            <td>
                                <a href="{{ route('perawat.rekammedis.index', ['pet' => $pasien->idpet]) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-journal-medical"></i> Lihat Rekam Medis
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Tidak ada data pasien.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

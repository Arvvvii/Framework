@extends('layouts.dokter.main')

@section('title', 'Dashboard Dokter')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard Dokter</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        {{-- Info Boxes --}}
        <div class="row">
            <div class="col-lg-4 col-6">
                <div class="small-box text-bg-primary">
                    <div class="inner">
                        <h3>{{ $stats['today_visits'] }}</h3>
                        <p>Kunjungan Hari Ini</p>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                    </svg>
                    <a href="{{ route('dokter.pasien.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        Lihat Detail <i class="bi bi-arrow-right-circle-fill"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box text-bg-success">
                    <div class="inner">
                        <h3>{{ $stats['active_patients'] }}</h3>
                        <p>Pasien Aktif (7 Hari)</p>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"></path>
                    </svg>
                    <a href="#" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        Lihat Detail <i class="bi bi-arrow-right-circle-fill"></i>
                    </a>
                </div>
            </div>

            <div class="col-lg-4 col-6">
                <div class="small-box text-bg-warning">
                    <div class="inner">
                        <h3>{{ $stats['pending_examinations'] }}</h3>
                        <p>Pemeriksaan Tertunda</p>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M2.625 6.75a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0zm4.875 0A.75.75 0 018.25 6h12a.75.75 0 010 1.5h-12a.75.75 0 01-.75-.75zM2.625 12a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0zM7.5 12a.75.75 0 01.75-.75h12a.75.75 0 010 1.5h-12A.75.75 0 017.5 12zm-4.875 5.25a1.125 1.125 0 112.25 0 1.125 1.125 0 01-2.25 0zm4.875 0a.75.75 0 01.75-.75h12a.75.75 0 010 1.5h-12a.75.75 0 01-.75-.75z"></path>
                    </svg>
                    <a href="#" class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                        Lihat Detail <i class="bi bi-arrow-right-circle-fill"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Recent Medical Records --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Rekam Medis Terbaru</h3>
                        <div class="card-tools">
                            <a href="{{ route('dokter.pasien.index') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> Lihat Semua
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Hewan</th>
                                        <th>Pemilik</th>
                                        <th>Anamnesa</th>
                                        <th>Diagnosa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recent_records as $record)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($record->created_at)->format('d/m/Y H:i') }}</td>
                                            <td>{{ $record->temuDokter->pet->nama_pet ?? '-' }}</td>
                                            <td>{{ $record->temuDokter->pet->pemilik->nama_pemilik ?? '-' }}</td>
                                            <td>{{ Str::limit($record->anamnesa, 50) }}</td>
                                            <td>{{ Str::limit($record->diagnosa, 50) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">Belum ada rekam medis</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Aksi Cepat</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('dokter.pasien.index') }}" class="btn btn-app">
                            <i class="bi bi-file-medical"></i> Rekam Medis
                        </a>
                        <a href="#" class="btn btn-app">
                            <i class="bi bi-calendar-check"></i> Jadwal
                        </a>
                        <a href="#" class="btn btn-app">
                            <i class="bi bi-heart-pulse"></i> Pasien
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

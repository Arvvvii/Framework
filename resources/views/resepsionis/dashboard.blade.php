@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row bg-info text-white py-4 mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4"><i class="fas fa-hospital"></i> Rumah Sakit Hewan</h1>
            <p class="lead">Dashboard Resepsionis</p>
        </div>
    </div>

    <!-- Welcome Message -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info" role="alert">
                <h4 class="alert-heading"><i class="fas fa-user-check"></i> Selamat Datang, Resepsionis!</h4>
                <p>Anda telah berhasil login sebagai Resepsionis. Bantu pelanggan dengan pelayanan terbaik.</p>
                <hr>
                <p class="mb-0">Gunakan menu di bawah untuk mengakses fitur-fitur resepsionis.</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card border-primary h-100">
                <div class="card-body text-center">
                    <i class="fas fa-calendar-plus fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">{{ $stats['today_registrations'] ?? 0 }}</h5>
                    <p class="card-text">Pendaftaran Hari Ini</p>
                    <button class="btn btn-primary">Daftar Pasien</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success h-100">
                <div class="card-body text-center">
                    <i class="fas fa-paw fa-3x text-success mb-3"></i>
                    <h5 class="card-title">{{ $stats['total_patients'] ?? 0 }}</h5>
                    <p class="card-text">Total Pasien</p>
                    <button class="btn btn-success">Lihat Pasien</button>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-warning h-100">
                <div class="card-body text-center">
                    <i class="fas fa-user-md fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">{{ $stats['total_owners'] ?? 0 }}</h5>
                    <p class="card-text">Total Pemilik</p>
                    <button class="btn btn-warning">Lihat Pemilik</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Menu Resepsionis</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary"><i class="fas fa-user-plus"></i> Pendaftaran & Pasien</h6>
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-decoration-none">
                                        <i class="fas fa-plus-circle"></i> Daftar Pasien Baru
                                    </a>
                                    <span class="badge bg-primary rounded-pill">Baru</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-decoration-none">
                                        <i class="fas fa-edit"></i> Update Data Pasien
                                    </a>
                                    <span class="badge bg-primary rounded-pill">Update</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-decoration-none">
                                        <i class="fas fa-search"></i> Cari Pasien
                                    </a>
                                    <span class="badge bg-primary rounded-pill">Cari</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-success"><i class="fas fa-calendar-alt"></i> Jadwal & Reservasi</h6>
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-decoration-none">
                                        <i class="fas fa-calendar-plus"></i> Buat Reservasi
                                    </a>
                                    <span class="badge bg-success rounded-pill">Reservasi</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-decoration-none">
                                        <i class="fas fa-clock"></i> Lihat Jadwal Dokter
                                    </a>
                                    <span class="badge bg-success rounded-pill">Jadwal</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-decoration-none">
                                        <i class="fas fa-check-circle"></i> Konfirmasi Reservasi
                                    </a>
                                    <span class="badge bg-success rounded-pill">Konfirmasi</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-info"><i class="fas fa-file-medical"></i> Rekam Medis</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-decoration-none">
                                        <i class="fas fa-file-alt"></i> Lihat Rekam Medis
                                    </a>
                                    <span class="badge bg-info rounded-pill">Lihat</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-decoration-none">
                                        <i class="fas fa-print"></i> Cetak Rekam Medis
                                    </a>
                                    <span class="badge bg-info rounded-pill">Cetak</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-secondary"><i class="fas fa-info-circle"></i> Informasi Sistem</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-1"><strong>Versi:</strong> 1.0.0</p>
                                    <p class="mb-1"><strong>Role:</strong> Resepsionis</p>
                                    <p class="mb-0"><strong>Login:</strong> {{ session('user_name') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
body {
    background-color: #f8f9fa;
}
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: none;
    border-radius: 0.5rem;
}
.card-header {
    border-radius: 0.5rem 0.5rem 0 0 !important;
}
.list-group-item {
    border: none;
    padding: 0.75rem 1.25rem;
}
.list-group-item a {
    color: #495057;
    font-weight: 500;
}
.list-group-item a:hover {
    color: #007bff;
    text-decoration: none;
}
.alert-info {
    border-radius: 0.5rem;
}
.h-100 {
    height: 100%;
}
</style>
@endsection

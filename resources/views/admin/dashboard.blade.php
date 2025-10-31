@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row bg-primary text-white py-4 mb-4">
        <div class="col-12 text-center">
            <h1 class="display-4"><i class="fas fa-hospital"></i> Rumah Sakit Hewan</h1>
            <p class="lead">Dashboard Administrator</p>
        </div>
    </div>

    <!-- Welcome Message -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading"><i class="fas fa-user-shield"></i> Selamat Datang, Administrator!</h4>
                <p>Anda telah berhasil login sebagai Administrator. Kelola sistem rumah sakit hewan dengan bijak.</p>
                <hr>
                <p class="mb-0">Gunakan menu di bawah untuk mengakses berbagai fitur manajemen data.</p>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">{{ $stats['total_users'] ?? 0 }}</h5>
                    <p class="card-text">Data User</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-paw fa-3x text-success mb-3"></i>
                    <h5 class="card-title">{{ $stats['total_pets'] ?? 0 }}</h5>
                    <p class="card-text">Pet</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="fas fa-user-md fa-3x text-info mb-3"></i>
                    <h5 class="card-title">{{ $stats['total_pemilik'] ?? 0 }}</h5>
                    <p class="card-text">Pemilik</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="fas fa-tags fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">{{ $stats['total_kategori_klinis'] ?? 0 }}</h5>
                    <p class="card-text">Kategori Klinis</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Section -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="fas fa-list"></i> Menu Administrator</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-primary"><i class="fas fa-user-cog"></i> Manajemen Pengguna</h6>
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('admin.role.index') }}" class="text-decoration-none">
                                        <i class="fas fa-shield-alt"></i> Role
                                    </a>
                                    <span class="badge bg-primary rounded-pill">Kelola</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('admin.datauser.index') }}" class="text-decoration-none">
                                        <i class="fas fa-users"></i> Data User
                                    </a>
                                    <span class="badge bg-primary rounded-pill">Kelola</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-success"><i class="fas fa-heartbeat"></i> Data Medis</h6>
                            <ul class="list-group list-group-flush mb-3">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('admin.pet.index') }}" class="text-decoration-none">
                                        <i class="fas fa-paw"></i> Pet
                                    </a>
                                    <span class="badge bg-success rounded-pill">Kelola</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('admin.pemilik.index') }}" class="text-decoration-none">
                                        <i class="fas fa-user-md"></i> Pemilik
                                    </a>
                                    <span class="badge bg-success rounded-pill">Kelola</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('admin.kategoriklinis.index') }}" class="text-decoration-none">
                                        <i class="fas fa-stethoscope"></i> Kategori Klinis
                                    </a>
                                    <span class="badge bg-success rounded-pill">Kelola</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('admin.kodeterapi.index') }}" class="text-decoration-none">
                                        <i class="fas fa-pills"></i> Kode Terapi
                                    </a>
                                    <span class="badge bg-success rounded-pill">Kelola</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-info"><i class="fas fa-tags"></i> Klasifikasi</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('admin.kategori.index') }}" class="text-decoration-none">
                                        <i class="fas fa-tag"></i> Kategori
                                    </a>
                                    <span class="badge bg-info rounded-pill">Kelola</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('admin.jenishewan.index') }}" class="text-decoration-none">
                                        <i class="fas fa-dna"></i> Jenis Hewan
                                    </a>
                                    <span class="badge bg-info rounded-pill">Kelola</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('admin.rashewan.index') }}" class="text-decoration-none">
                                        <i class="fas fa-seedling"></i> Ras Hewan
                                    </a>
                                    <span class="badge bg-info rounded-pill">Kelola</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-secondary"><i class="fas fa-info-circle"></i> Informasi Sistem</h6>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <p class="mb-1"><strong>Versi:</strong> 1.0.0</p>
                                    <p class="mb-1"><strong>Role:</strong> Administrator</p>
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
.alert-success {
    border-radius: 0.5rem;
}
</style>
@endsection

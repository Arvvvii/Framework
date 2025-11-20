@extends('layouts.resepsionis.main')

@section('title', 'Dashboard Resepsionis')

@section('content')
<!-- Content Header (Page header) -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard Resepsionis</h3>
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
<!-- /.content-header -->

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon text-bg-primary shadow-sm">
                        <i class="fas fa-users"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Pemilik</span>
                        <span class="info-box-number">{{ $totalPemilik }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon text-bg-success shadow-sm">
                        <i class="fas fa-paw"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Pet</span>
                        <span class="info-box-number">{{ $totalPet }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-4">
                <div class="info-box">
                    <span class="info-box-icon text-bg-warning shadow-sm">
                        <i class="fas fa-calendar-check"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Temu Dokter</span>
                        <span class="info-box-number">{{ $totalTemuDokter }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Quick Actions</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-primary">
                                        <i class="fas fa-user-plus"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Kelola Pemilik</span>
                                        <a href="{{ route('resepsionis.pemilik.index') }}" class="btn btn-sm btn-primary mt-2">
                                            <i class="fas fa-arrow-right"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-success">
                                        <i class="fas fa-paw"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Kelola Pet</span>
                                        <a href="{{ route('resepsionis.pet.index') }}" class="btn btn-sm btn-success mt-2">
                                            <i class="fas fa-arrow-right"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6 col-12">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-warning">
                                        <i class="fas fa-calendar-check"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Kelola Temu Dokter</span>
                                        <a href="{{ route('resepsionis.temudokter.index') }}" class="btn btn-sm btn-warning mt-2">
                                            <i class="fas fa-arrow-right"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.content -->
@endsection

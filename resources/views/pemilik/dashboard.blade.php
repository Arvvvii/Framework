@extends('layouts.pemilik.main')

@section('title', 'Dashboard Pemilik')

@section('content')
<!-- Content Header (Page header) -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard Pemilik</h3>
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
            <div class="col-12 col-sm-6 col-md-6">
                <div class="info-box">
                    <span class="info-box-icon text-bg-success shadow-sm">
                        <i class="fas fa-paw"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Pet Saya</span>
                        <span class="info-box-number">{{ $totalPets }}</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-6">
                <div class="info-box">
                    <span class="info-box-icon text-bg-info shadow-sm">
                        <i class="fas fa-file-medical"></i>
                    </span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Rekam Medis</span>
                        <span class="info-box-number">{{ $totalRekamMedis }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Menu</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-success">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Profil & Pet Saya</span>
                                        <span class="info-box-number">Lihat profil pemilik dan daftar pet yang dimiliki</span>
                                        <a href="{{ route('pemilik.pet.index') }}" class="btn btn-sm btn-success mt-2">
                                            <i class="fas fa-arrow-right"></i> Lihat
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-12">
                                <div class="info-box bg-light">
                                    <span class="info-box-icon bg-info">
                                        <i class="fas fa-file-medical"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Rekam Medis</span>
                                        <span class="info-box-number">Lihat riwayat rekam medis pet</span>
                                        <a href="{{ route('pemilik.rekammedis.index') }}" class="btn btn-sm btn-info mt-2">
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

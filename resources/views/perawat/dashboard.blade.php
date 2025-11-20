@extends('layouts.perawat.main')

@section('title', 'Dashboard Perawat')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Dashboard Perawat</h3>
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
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Info Boxes --}}
        <div class="row">
            <div class="col-lg-6 col-6">
                <div class="small-box text-bg-info">
                    <div class="inner">
                        <h3>{{ $totalRekamMedis ?? 0 }}</h3>
                        <p>Total Rekam Medis</p>
                    </div>
                    <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"></path>
                        <path clip-rule="evenodd" fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"></path>
                    </svg>
                    <a href="{{ route('perawat.rekammedis.index') }}" class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                        Lihat Detail <i class="bi bi-arrow-right-circle-fill"></i>
                    </a>
                </div>
            </div>

            <!-- Removed perawat Tindakan Terapi info box (not available for Perawat role) -->
        </div>

        {{-- Quick Actions --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Aksi Cepat</h3>
                    </div>
                    <div class="card-body">
                        <a href="{{ route('perawat.rekammedis.index') }}" class="btn btn-app">
                            <i class="bi bi-file-medical"></i> Rekam Medis
                        </a>
                        <!-- Tindakan Terapi button removed for Perawat -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

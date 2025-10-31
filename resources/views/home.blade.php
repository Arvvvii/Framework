@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                
                <!-- Card Header sekarang menampilkan nama user -->
                <div class="card-header">{{__('Dashboard')}} - {{ session('user_name') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }} Anda sebagai **{{ session('user_role_name') }}**
                    
                    <h5 class="mt-4 mb-3" style="border-bottom: 1px solid #eee; padding-bottom: 5px;">Akses Master Data:</h5>

                    <!-- DAFTAR LINK ADMIN (Menggunakan Route Helper yang sudah Anda daftarkan) -->
                    <div class="mt-4">
                        <div class="row">

                            <!-- Jenis Hewan -->
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.jenishewan.index') }}" class="btn btn-primary btn-block w-100">
                                    <i class="fas fa-paw"></i> Daftar Jenis Hewan
                                </a>
                            </div>

                            <!-- Pemilik -->
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.pemilik.index') }}" class="btn btn-success btn-block w-100">
                                    <i class="fas fa-users"></i> Daftar Pemilik
                                </a>
                            </div>

                            <!-- Role -->
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.role.index') }}" class="btn btn-info btn-block w-100" style="color: white;">
                                    <i class="fas fa-user-tag"></i> Daftar Role
                                </a>
                            </div>
                            
                            <!-- Pet -->
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.pet.index') }}" class="btn btn-warning btn-block w-100">
                                    <i class="fas fa-dog"></i> Daftar Pet
                                </a>
                            </div>

                            <!-- Ras Hewan -->
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.rashewan.index') }}" class="btn btn-dark btn-block w-100">
                                    <i class="fas fa-bone"></i> Daftar Ras Hewan
                                </a>
                            </div>

                            <!-- Kategori Klinis -->
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.kategoriklinis.index') }}" class="btn btn-secondary btn-block w-100">
                                    <i class="fas fa-syringe"></i> Kategori Klinis
                                </a>
                            </div>
                            
                            <!-- Kategori (Asumsi: Master Umum) -->
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.kategori.index') }}" class="btn btn-light btn-outline-dark btn-block w-100">
                                    <i class="fas fa-list-alt"></i> Daftar Kategori
                                </a>
                            </div>
                            
                            <!-- Kode Tindakan Terapi -->
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.kodeterapi.index') }}" class="btn btn-danger btn-block w-100">
                                    <i class="fas fa-notes-medical"></i> Kode Terapi
                                </a>
                            </div>

                            <!-- User (Tugas Modul 9/8) -->
                            <div class="col-md-12 mb-2">
                                <a href="{{ route('admin.datauser.index') }}" class="btn btn-outline-primary btn-block w-100">
                                    <i class="fas fa-users-cog"></i> Daftar User dengan Role
                                </a>
                            </div>

                        </div>
                    </div>
                    <!-- AKHIR DAFTAR LINK ADMIN -->

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.dokter.main')

@section('title', 'Profil Dokter')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Profil Saya</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profil</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Profil Dokter</h3>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Nama</dt>
                    <dd class="col-sm-9">{{ optional($dokter->user)->nama ?? '-' }}</dd>
                    <dt class="col-sm-3">Email</dt>
                    <dd class="col-sm-9">{{ optional($dokter->user)->email ?? '-' }}</dd>
                    <dt class="col-sm-3">Telepon</dt>
                    <dd class="col-sm-9">{{ $dokter->no_hp ?? '-' }}</dd>
                    <dt class="col-sm-3">Alamat</dt>
                    <dd class="col-sm-9">{{ $dokter->alamat ?? '-' }}</dd>
                    <dt class="col-sm-3">Spesialisasi</dt>
                    <dd class="col-sm-9">{{ $dokter->bidang_dokter ?? '-' }}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
@endsection

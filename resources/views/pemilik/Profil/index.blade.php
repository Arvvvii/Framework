@extends('layouts.pemilik.main')

@section('title', 'Profil Saya')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Profil Saya</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Profil</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Profil Pemilik</h3></div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <dl class="row">
                    <dt class="col-sm-3">Nama</dt>
                    <dd class="col-sm-9">{{ optional($pemilik->user)->nama ?? '-' }}</dd>
                    <dt class="col-sm-3">Email</dt>
                    <dd class="col-sm-9">{{ optional($pemilik->user)->email ?? '-' }}</dd>
                    <dt class="col-sm-3">No. WA</dt>
                    <dd class="col-sm-9">{{ $pemilik->no_wa ?? '-' }}</dd>
                    <dt class="col-sm-3">Alamat</dt>
                    <dd class="col-sm-9">{{ $pemilik->alamat ?? '-' }}</dd>
                </dl>
                <a href="{{ route('pemilik.profil.edit') }}" class="btn btn-primary">Edit Profil</a>
            </div>
        </div>
    </div>
</div>
@endsection

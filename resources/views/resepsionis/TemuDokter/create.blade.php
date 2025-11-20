@extends('layouts.resepsionis.main')

@section('title', 'Buat Janji Temu Dokter')

@section('content')
<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Buat Janji Temu Dokter</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.temudokter.index') }}">Temu Dokter</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Buat Janji</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form Janji Temu Dokter</h3>
                    </div>
                    <form action="{{ route('resepsionis.temudokter.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="id_pet" class="form-label">Pilih Pet <span class="text-danger">*</span></label>
                                <select name="id_pet" id="id_pet" class="form-select @error('id_pet') is-invalid @enderror" required>
                                    <option value="">-- Pilih Pet --</option>
                                    @foreach($pets as $pet)
                                        <option value="{{ $pet->idpet }}" {{ old('id_pet') == $pet->idpet ? 'selected' : '' }}>
                                            {{ $pet->nama }} - {{ $pet->rasHewan->nama_ras ?? 'N/A' }} 
                                            (Pemilik: {{ $pet->pemilik->user->nama ?? 'N/A' }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_pet')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="waktu_daftar" class="form-label">Waktu Janji Temu <span class="text-danger">*</span></label>
                                <input type="datetime-local" name="waktu_daftar" id="waktu_daftar" value="{{ old('waktu_daftar') }}" class="form-control @error('waktu_daftar') is-invalid @enderror" required>
                                @error('waktu_daftar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="keluhan" class="form-label">Keluhan <span class="text-danger">*</span></label>
                                <textarea name="keluhan" id="keluhan" rows="4" class="form-control @error('keluhan') is-invalid @enderror" required placeholder="Tuliskan keluhan pet...">{{ old('keluhan') }}</textarea>
                                @error('keluhan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-calendar-check"></i> Buat Janji
                            </button>
                            <a href="{{ route('resepsionis.temudokter.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

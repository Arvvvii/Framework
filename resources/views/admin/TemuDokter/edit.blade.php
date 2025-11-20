@extends('layouts.admin.main')

@section('title', 'Edit Temu Dokter')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Janji Temu Dokter</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.temudokter.index') }}">Temu Dokter</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form Edit Janji Temu</h3>
                    </div>
                    <form action="{{ route('admin.temudokter.update', $temuDokter->idreservasi_dokter ?? $temuDokter->idtemu_dokter) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="idpet" class="form-label">Pilih Hewan</label>
                                <select name="idpet" id="idpet" class="form-control" required>
                                    <option value="">-- Pilih Hewan --</option>
                                    @foreach($pets as $pet)
                                        <option value="{{ $pet->idpet }}" {{ $temuDokter->idpet == $pet->idpet ? 'selected' : '' }}>{{ $pet->nama }} - {{ $pet->pemilik->user->nama ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="waktu_daftar" class="form-label">Tanggal & Waktu Daftar</label>
                                <input type="datetime-local" name="waktu_daftar" id="waktu_daftar" class="form-control" value="{{ $temuDokter->waktu_daftar ? $temuDokter->waktu_daftar->format('Y-m-d\TH:i') : '' }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="keluhan" class="form-label">Keluhan</label>
                                <textarea name="keluhan" id="keluhan" class="form-control" rows="3" required>{{ $temuDokter->keluhan }}</textarea>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('admin.temudokter.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin.main')

@section('title', 'Edit Rekam Medis')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Rekam Medis</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.rekammedis.index') }}">Rekam Medis</a></li>
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
                        <h3 class="card-title">Form Edit Rekam Medis</h3>
                    </div>
                    <form action="{{ route('admin.rekammedis.update', $rekammedi->idrekam_medis) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="anamnesa" class="form-label">Anamnesa</label>
                                <textarea name="anamnesa" id="anamnesa" class="form-control" required>{{ old('anamnesa', $rekammedi->anamnesa) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="temuan_klinis" class="form-label">Temuan Klinis</label>
                                <textarea name="temuan_klinis" id="temuan_klinis" class="form-control">{{ old('temuan_klinis', $rekammedi->temuan_klinis) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="diagnosa" class="form-label">Diagnosa</label>
                                <textarea name="diagnosa" id="diagnosa" class="form-control">{{ old('diagnosa', $rekammedi->diagnosa) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="dokter_pemeriksa" class="form-label">Dokter Pemeriksa (RoleUser)</label>
                                <select name="dokter_pemeriksa" id="dokter_pemeriksa" class="form-select" required>
                                    <option value="">-- Pilih Dokter --</option>
                                    @foreach($dokters as $d)
                                        <option value="{{ $d->idrole_user }}" {{ old('dokter_pemeriksa', $rekammedi->dokter_pemeriksa) == $d->idrole_user ? 'selected' : '' }}>{{ $d->user->nama ?? ('#' . $d->idrole_user) }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="idreservasi_dokter" class="form-label">Reservasi Dokter (TemuDokter)</label>
                                <select name="idreservasi_dokter" id="idreservasi_dokter" class="form-select" required>
                                    <option value="">-- Pilih Reservasi --</option>
                                    @foreach($temuDokters as $t)
                                        <option value="{{ $t->idreservasi_dokter }}" {{ old('idreservasi_dokter', $rekammedi->idreservasi_dokter) == $t->idreservasi_dokter ? 'selected' : '' }}>{{ optional($t->pet)->nama ?? 'Reservasi #' . $t->idreservasi_dokter }} - {{ $t->waktu_daftar?->format('d-m-Y H:i') ?? '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('admin.rekammedis.index') }}" class="btn btn-secondary">Batal</a>
                            <button class="btn btn-primary" type="submit">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
 </div>
@endsection

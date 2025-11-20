@extends('layouts.perawat.main')

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
                    <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('perawat.rekammedis.index') }}">Rekam Medis</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>Edit Rekam Medis</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('perawat.rekammedis.update', $rekamMedis->idrekam_medis) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="idreservasi_dokter" class="form-label">Pilih Reservasi (Hewan - Pemilik)</label>
                        <select name="idreservasi_dokter" id="idreservasi_dokter" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            @foreach($temuDokters as $t)
                                <option value="{{ $t->idreservasi_dokter }}" {{ $rekamMedis->idreservasi_dokter == $t->idreservasi_dokter ? 'selected' : '' }}>{{ $t->pet->nama ?? '-' }} - {{ $t->pet->pemilik->user->nama ?? '-' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="anamnesa" class="form-label">Anamnesa</label>
                        <textarea name="anamnesa" id="anamnesa" class="form-control" rows="3">{{ old('anamnesa', $rekamMedis->anamnesa) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="temuan_klinis" class="form-label">Temuan Klinis</label>
                        <textarea name="temuan_klinis" id="temuan_klinis" class="form-control" rows="3">{{ old('temuan_klinis', $rekamMedis->temuan_klinis) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="diagnosa" class="form-label">Diagnosa</label>
                        <textarea name="diagnosa" id="diagnosa" class="form-control" rows="2">{{ old('diagnosa', $rekamMedis->diagnosa) }}</textarea>
                    </div>

                    <button class="btn btn-primary">Perbarui</button>
                    <a href="{{ route('perawat.rekammedis.index') }}" class="btn btn-secondary">Batal</a>
                </form>

                <form action="{{ route('perawat.rekammedis.destroy', $rekamMedis->idrekam_medis) }}" method="POST" class="mt-3" onsubmit="return confirm('Hapus rekam medis ini?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">Hapus Rekam Medis</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

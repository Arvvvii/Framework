@extends('layouts.perawat.main')

@section('title', 'Buat Rekam Medis')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Buat Rekam Medis</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('perawat.rekammedis.index') }}">Rekam Medis</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Buat</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>Form Rekam Medis</h5>
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

                <form action="{{ route('perawat.rekammedis.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="idreservasi_dokter" class="form-label">Pilih Reservasi (Hewan - Pemilik)</label>
                        <select name="idreservasi_dokter" id="idreservasi_dokter" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            @foreach($temuDokters as $t)
                                <option value="{{ $t->idreservasi_dokter }}"
                                    @if(old('idreservasi_dokter') == $t->idreservasi_dokter) selected
                                    @elseif(isset($selectedReservasi) && $selectedReservasi == $t->idreservasi_dokter) selected
                                    @endif
                                >{{ $t->pet->nama ?? '-' }} - {{ $t->pet->pemilik->user->nama ?? '-' }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="anamnesa" class="form-label">Anamnesa</label>
                        <textarea name="anamnesa" id="anamnesa" class="form-control" rows="3">{{ old('anamnesa') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="temuan_klinis" class="form-label">Temuan Klinis</label>
                        <textarea name="temuan_klinis" id="temuan_klinis" class="form-control" rows="3">{{ old('temuan_klinis') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="diagnosa" class="form-label">Diagnosa</label>
                        <textarea name="diagnosa" id="diagnosa" class="form-control" rows="2">{{ old('diagnosa') }}</textarea>
                    </div>

                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('perawat.rekammedis.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

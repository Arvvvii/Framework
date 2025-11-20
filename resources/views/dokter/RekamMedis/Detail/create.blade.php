@extends('layouts.dokter.main')

@section('title', 'Tambah Detail Tindakan/Terapi')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Tambah Detail Tindakan/Terapi</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dokter.pasien.index') }}">Data Pasien</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dokter.rekammedis.index', ['pet' => $petId]) }}">Rekam Medis</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dokter.rekammedis.detail.index', [$rekamMedis->idrekam_medis, 'pet' => $petId]) }}">Detail</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('dokter.rekammedis.detail.store', [$rekamMedis->idrekam_medis, 'pet' => $petId]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="idkode_tindakan_terapi" class="form-label">Kode Tindakan/Terapi</label>
                        <select name="idkode_tindakan_terapi" id="idkode_tindakan_terapi" class="form-control" required>
                            <option value="">-- Pilih Kode Tindakan/Terapi --</option>
                            @foreach($kodeTindakan as $kode)
                                <option value="{{ $kode->idkode_tindakan_terapi }}">{{ $kode->kode }} - {{ $kode->deskripsi_tindakan_terapi }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="detail" class="form-label">Detail</label>
                        <textarea name="detail" id="detail" class="form-control" rows="3" required>{{ old('detail') }}</textarea>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('dokter.rekammedis.detail.index', [$rekamMedis->idrekam_medis, 'pet' => $petId]) }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

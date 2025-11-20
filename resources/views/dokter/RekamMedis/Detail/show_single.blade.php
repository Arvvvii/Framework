@extends('layouts.dokter.main')

@section('title', 'Detail Tindakan/Terapi')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Detail Tindakan/Terapi</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dokter.pasien.index') }}">Data Pasien</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dokter.rekammedis.index', ['pet' => $petId]) }}">Rekam Medis</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dokter.rekammedis.detail.index', [$rekamMedis->idrekam_medis, 'pet' => $petId]) }}">Detail</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header">
                <h5>Data Detail Tindakan/Terapi</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Kode</dt>
                    <dd class="col-sm-9">{{ $detail->kodeTindakanTerapi->kode ?? '-' }} - {{ $detail->kodeTindakanTerapi->deskripsi_tindakan_terapi ?? '-' }}</dd>
                    <dt class="col-sm-3">Detail</dt>
                    <dd class="col-sm-9">{{ $detail->detail }}</dd>
                    <dt class="col-sm-3">Tanggal</dt>
                    <dd class="col-sm-9">{{ $detail->created_at?->format('d-m-Y H:i') }}</dd>
                </dl>
                <div class="text-end">
                    <a href="{{ route('dokter.rekammedis.detail.edit', [$rekamMedis->idrekam_medis, $detail->iddetail_rekam_medis, 'pet' => $petId]) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('dokter.rekammedis.detail.destroy', [$rekamMedis->idrekam_medis, $detail->iddetail_rekam_medis, 'pet' => $petId]) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Yakin hapus detail ini?')">Hapus</button>
                    </form>
                    <a href="{{ route('dokter.rekammedis.detail.index', [$rekamMedis->idrekam_medis, 'pet' => $petId]) }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.perawat.main')

@section('title', 'Rekam Medis Detail')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Rekam Medis Detail</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('perawat.pasien.index') }}">Data Pasien</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Rekam Medis</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="card mb-3">
            <div class="card-header">
                <h5>Data Rekam Medis</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">ID</dt>
                    <dd class="col-sm-9">{{ $rekamMedis->idrekam_medis }}</dd>
                    <dt class="col-sm-3">Tanggal</dt>
                    <dd class="col-sm-9">{{ $rekamMedis->created_at?->format('d-m-Y H:i') }}</dd>
                    <dt class="col-sm-3">Nama Hewan</dt>
                    <dd class="col-sm-9">{{ $rekamMedis->temuDokter->pet->nama ?? '-' }}</dd>
                    <dt class="col-sm-3">Pemilik</dt>
                    <dd class="col-sm-9">{{ $rekamMedis->temuDokter->pet->pemilik->user->nama ?? '-' }}</dd>
                    <dt class="col-sm-3">Anamnesa</dt>
                    <dd class="col-sm-9">{{ $rekamMedis->anamnesa ?? '-' }}</dd>
                    <dt class="col-sm-3">Temuan Klinis</dt>
                    <dd class="col-sm-9">{{ $rekamMedis->temuan_klinis ?? '-' }}</dd>
                    <dt class="col-sm-3">Diagnosa</dt>
                    <dd class="col-sm-9">{{ $rekamMedis->diagnosa ?? '-' }}</dd>
                </dl>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Detail Tindakan / Terapi</h5>
            </div>
            <div class="card-body">
                @if($rekamMedis->detailRekamMedis && $rekamMedis->detailRekamMedis->count())
                    <ul class="list-group">
                        @foreach($rekamMedis->detailRekamMedis as $detail)
                            <li class="list-group-item">
                                <strong>{{ $detail->kodeTindakanTerapi->kode ?? '-' }}</strong> - {{ $detail->kodeTindakanTerapi->deskripsi_tindakan_terapi ?? '-' }}
                                <div class="small text-muted">{{ $detail->created_at?->format('d-m-Y H:i') }}</div>
                                <div>{{ $detail->detail }}</div>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <div class="text-center">Belum ada detail tindakan.</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

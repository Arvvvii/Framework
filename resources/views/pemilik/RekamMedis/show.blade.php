@extends('layouts.pemilik.main')

@section('title', 'Detail Rekam Medis')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Detail Rekam Medis</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('pemilik.rekammedis.index') }}">Rekam Medis</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detail</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Informasi Rekam Medis</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-3">ID Rekam Medis</dt>
                            <dd class="col-sm-9">{{ $rekamMedis->idrekam_medis }}</dd>

                            <dt class="col-sm-3">Tanggal</dt>
                            <dd class="col-sm-9">{{ $rekamMedis->created_at?->format('d-m-Y H:i') ?? 'N/A' }}</dd>

                            <dt class="col-sm-3">Nama Pet</dt>
                            <dd class="col-sm-9">{{ $rekamMedis->temuDokter->pet->nama ?? '-' }}</dd>

                            <dt class="col-sm-3">Dokter Pemeriksa</dt>
                            <dd class="col-sm-9">{{ $rekamMedis->roleUser->user->nama ?? '-' }}</dd>

                            <dt class="col-sm-3">Anamnesa</dt>
                            <dd class="col-sm-9">{{ $rekamMedis->anamnesa ?? '-' }}</dd>

                            <dt class="col-sm-3">Temuan Klinis</dt>
                            <dd class="col-sm-9">{{ $rekamMedis->temuan_klinis ?? '-' }}</dd>

                            <dt class="col-sm-3">Diagnosa</dt>
                            <dd class="col-sm-9">{{ $rekamMedis->diagnosa ?? '-' }}</dd>
                        </dl>

                        <hr>
                        <h5>Detail Tindakan/Terapi</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Kode Tindakan/Terapi</th>
                                        <th>Nama</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @forelse($rekamMedis->detailRekamMedis as $i => $detail)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $detail->kodeTindakanTerapi->kode ?? '-' }}</td>
                                        <td>{{ $detail->kodeTindakanTerapi->nama ?? '-' }}</td>
                                        <td>{{ $detail->keterangan ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada detail tindakan/terapi.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <a href="{{ route('pemilik.rekammedis.index') }}" class="btn btn-secondary">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

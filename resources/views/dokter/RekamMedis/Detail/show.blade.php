@extends('layouts.dokter.main')

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
                    <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dokter.pasien.index') }}">Data Pasien</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dokter.rekammedis.index', ['pet' => $petId]) }}">Rekam Medis</a></li>
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
                <h5>Data Rekam Medis</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Tanggal</dt>
                    <dd class="col-sm-9">{{ $rekamMedis->created_at?->format('d-m-Y H:i') }}</dd>
                    <dt class="col-sm-3">Anamnesa</dt>
                    <dd class="col-sm-9">{{ $rekamMedis->anamnesa }}</dd>
                    <dt class="col-sm-3">Temuan Klinis</dt>
                    <dd class="col-sm-9">{{ $rekamMedis->temuan_klinis }}</dd>
                    <dt class="col-sm-3">Diagnosa</dt>
                    <dd class="col-sm-9">{{ $rekamMedis->diagnosa }}</dd>
                </dl>
            </div>
        </div>
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Detail Tindakan/Terapi</h5>
                <a href="{{ route('dokter.rekammedis.detail.create', [$rekamMedis->idrekam_medis, 'pet' => $petId]) }}" class="btn btn-primary btn-sm">
                    <i class="bi bi-plus-circle"></i> Tambah Detail
                </a>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode Tindakan/Terapi</th>
                            <th>Detail</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekamMedis->detailRekamMedis as $detail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $detail->kodeTindakanTerapi->kode ?? '-' }}@if(!empty($detail->kodeTindakanTerapi->deskripsi_tindakan_terapi)) - {{ $detail->kodeTindakanTerapi->deskripsi_tindakan_terapi }}@endif</td>
                            <td>{{ $detail->detail }}</td>
                            <td>
                                <a href="{{ route('dokter.rekammedis.detail.edit', [$rekamMedis->idrekam_medis, $detail->iddetail_rekam_medis, 'pet' => $petId]) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('dokter.rekammedis.detail.destroy', [$rekamMedis->idrekam_medis, $detail->iddetail_rekam_medis, 'pet' => $petId]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus detail ini?')"><i class="bi bi-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada detail tindakan/terapi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.admin.main')

@section('content')
<div class="container">
    <h1>Detail Rekam Medis #{{ $rekammedi->idrekam_medis }}</h1>

    <dl class="row">
        <dt class="col-sm-3">Anamnesa</dt>
        <dd class="col-sm-9">{{ $rekammedi->anamnesa }}</dd>

        <dt class="col-sm-3">Temuan Klinis</dt>
        <dd class="col-sm-9">{{ $rekammedi->temuan_klinis }}</dd>

        <dt class="col-sm-3">Diagnosa</dt>
        <dd class="col-sm-9">{{ $rekammedi->diagnosa }}</dd>

        <dt class="col-sm-3">Dokter Pemeriksa</dt>
        <dd class="col-sm-9">{{ optional($rekammedi->roleUser->user)->nama ?? 'N/A' }}</dd>

        <dt class="col-sm-3">Reservasi</dt>
        <dd class="col-sm-9">{{ optional($rekammedi->temuDokter->pet)->nama ?? 'Reservasi #' . $rekammedi->idreservasi_dokter }}</dd>
    </dl>

    <a href="{{ route('admin.rekammedis.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection

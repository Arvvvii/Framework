@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Rekam Medis</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.rekammedis.update', $rekammedi) }}" method="POST">
        @csrf
        @method('PUT')

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

        <button class="btn btn-primary" type="submit">Update</button>
        <a href="{{ route('admin.rekammedis.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

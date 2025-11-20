@extends('layouts.perawat.main')

@section('title', 'Tambah Detail Tindakan')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Tambah Detail Tindakan</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('perawat.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('perawat.rekammedis.index') }}">Rekam Medis</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h5>Tambah Tindakan untuk Rekam #{{ $rekamMedis->idrekam_medis }}</h5>
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

                <form action="{{ route('perawat.rekammedis.detail.store', $rekamMedis->idrekam_medis) }}?pet={{ $petId }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="idkode_tindakan_terapi" class="form-label">Pilih Kode Tindakan</label>
                        <select name="idkode_tindakan_terapi" id="idkode_tindakan_terapi" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            @foreach($kodeTindakan as $k)
                                <option value="{{ $k->idkode_tindakan_terapi }}">{{ $k->kode }} - {{ $k->deskripsi_tindakan_terapi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="detail" class="form-label">Catatan / Detail</label>
                        <textarea name="detail" id="detail" class="form-control" rows="3"></textarea>
                    </div>

                    <button class="btn btn-primary">Simpan</button>
                    <a href="{{ route('perawat.rekammedis.show', [$rekamMedis->idrekam_medis, 'pet' => $petId]) }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

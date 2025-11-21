@extends('layouts.admin.main')

@section('content')
<div class="container">
    <h1>Edit Kode Tindakan Terapi</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.kodeterapi.update', optional($kodeterapi)->idkode_tindakan_terapi) }}" method="post">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="kode" class="form-label">Kode</label>
            <input type="text" name="kode" id="kode" value="{{ old('kode', optional($kodeterapi)->kode) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="deskripsi_tindakan_terapi" class="form-label">Deskripsi</label>
            <input type="text" name="deskripsi_tindakan_terapi" id="deskripsi_tindakan_terapi" value="{{ old('deskripsi_tindakan_terapi', optional($kodeterapi)->deskripsi_tindakan_terapi) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="idkategori" class="form-label">Kategori</label>
            <select name="idkategori" id="idkategori" class="form-control">
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoris as $k)
                    <option value="{{ $k->idkategori }}" {{ (old('idkategori', $kodeterapi->idkategori) == $k->idkategori) ? 'selected' : '' }}>{{ $k->nama_kategori }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="idkategori_klinis" class="form-label">Kategori Klinis</label>
            <select name="idkategori_klinis" id="idkategori_klinis" class="form-control">
                <option value="">-- Pilih Kategori Klinis --</option>
                @foreach($kategorikliniss as $kk)
                    <option value="{{ $kk->idkategori_klinis }}" {{ (old('idkategori_klinis', $kodeterapi->idkategori_klinis) == $kk->idkategori_klinis) ? 'selected' : '' }}>{{ $kk->nama_kategori_klinis }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Perbarui</button>
        <a href="{{ route('admin.kodeterapi.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

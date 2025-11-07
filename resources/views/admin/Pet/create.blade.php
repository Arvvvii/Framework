@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Pet</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pet.store') }}" method="post">
        @csrf

        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="warna_tanda" class="form-label">Warna / Tanda</label>
            <input type="text" name="warna_tanda" id="warna_tanda" value="{{ old('warna_tanda') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                <option value="">-- Pilih --</option>
                <option value="Jantan" {{ old('jenis_kelamin') == 'Jantan' ? 'selected' : '' }}>Jantan</option>
                <option value="Betina" {{ old('jenis_kelamin') == 'Betina' ? 'selected' : '' }}>Betina</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="idpemilik" class="form-label">Pemilik</label>
            <select name="idpemilik" id="idpemilik" class="form-control">
                <option value="">-- Pilih Pemilik --</option>
                @foreach($pemiliks as $pemilik)
                    <option value="{{ $pemilik->idpemilik }}" {{ old('idpemilik') == $pemilik->idpemilik ? 'selected' : '' }}>
                        {{ optional($pemilik->user)->nama ?? 'User #' . $pemilik->idpemilik }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="idras_hewan" class="form-label">Ras Hewan</label>
            <select name="idras_hewan" id="idras_hewan" class="form-control">
                <option value="">-- Pilih Ras --</option>
                @foreach($rashewans as $ras)
                    <option value="{{ $ras->idras_hewan }}" {{ old('idras_hewan') == $ras->idras_hewan ? 'selected' : '' }}>
                        {{ $ras->nama_ras ?? 'Ras #' . $ras->idras_hewan }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.pet.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

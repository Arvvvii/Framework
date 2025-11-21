@extends('layouts.admin.main')

@section('content')
<div class="container">
    <h1>Tambah Ras Hewan</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.rashewan.store') }}" method="post">
        @csrf

        <div class="mb-3">
            <label for="nama_ras" class="form-label">Nama Ras</label>
            <input type="text" name="nama_ras" id="nama_ras" value="{{ old('nama_ras') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="idjenis_hewan" class="form-label">Jenis Hewan</label>
            <select name="idjenis_hewan" id="idjenis_hewan" class="form-control">
                <option value="">-- Pilih Jenis Hewan --</option>
                @foreach($jenishawans as $j)
                    <option value="{{ $j->idjenis_hewan }}" {{ old('idjenis_hewan') == $j->idjenis_hewan ? 'selected' : '' }}>{{ $j->nama_jenis_hewan }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.rashewan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

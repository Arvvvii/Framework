@extends('layouts.admin.main')

@section('content')
<div class="container">
    <h1>Edit Pemilik</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pemilik.update', optional($pemilik)->idpemilik) }}" method="post">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="no_wa" class="form-label">No. WA</label>
            <input type="text" name="no_wa" id="no_wa" value="{{ old('no_wa', $pemilik->no_wa ?? '') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $pemilik->alamat ?? '') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="iduser" class="form-label">User</label>
            <select name="iduser" id="iduser" class="form-control">
                <option value="">-- Pilih User --</option>
                @foreach($users as $u)
                    <option value="{{ $u->iduser }}" {{ (old('iduser', $pemilik->iduser ?? '') == $u->iduser) ? 'selected' : '' }}>
                        {{ $u->nama ?? ('User #' . $u->iduser) }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.pemilik.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

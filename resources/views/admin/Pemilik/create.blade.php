@extends('layouts.admin.main')

@section('content')
<div class="container">
    <h1>Tambah Pemilik</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pemilik.store') }}" method="post">
        @csrf

        <div class="mb-3">
            <label for="no_wa" class="form-label">No. WA</label>
            <input type="text" name="no_wa" id="no_wa" value="{{ old('no_wa') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <input type="text" name="alamat" id="alamat" value="{{ old('alamat') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="create_user" name="create_user" {{ old('create_user') ? 'checked' : '' }}>
                <label class="form-check-label" for="create_user">Buat akun pengguna baru</label>
            </div>
        </div>

        <div id="existingUserSection" class="mb-3">
            <label for="iduser" class="form-label">User</label>
            <select name="iduser" id="iduser" class="form-control">
                <option value="">-- Pilih User --</option>
                @foreach($users as $u)
                    <option value="{{ $u->iduser }}" {{ old('iduser') == $u->iduser ? 'selected' : '' }}>
                        {{ $u->nama ?? ('User #' . $u->iduser) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div id="newUserSection" class="mb-3" style="display:none;">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}">
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.pemilik.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function toggleUserSections() {
        const create = document.getElementById('create_user').checked;
        document.getElementById('existingUserSection').style.display = create ? 'none' : 'block';
        document.getElementById('newUserSection').style.display = create ? 'block' : 'none';
        // toggle requireds
        const idSel = document.getElementById('iduser');
        if (idSel) idSel.required = !create;
        ['nama','email','password','password_confirmation'].forEach(id => {
            const el = document.getElementById(id);
            if (el) el.required = create;
        });
    }
    document.getElementById('create_user').addEventListener('change', toggleUserSections);
    toggleUserSections();
}</script>
@endpush

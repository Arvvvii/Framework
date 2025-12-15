@extends('layouts.admin.main')

@section('title', 'Tambah Dokter')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tambah Data Dokter</h3>
                </div>
                <form action="{{ route('admin.dokter.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" id="create_user" name="create_user" {{ old('create_user') ? 'checked' : '' }}>
                                <label class="form-check-label" for="create_user">
                                    Buat akun pengguna baru
                                </label>
                            </div>
                        </div>

                        <div id="existingUserSection" class="mb-3" style="display: {{ old('create_user') ? 'none' : 'block' }};">
                            <label for="id_user" class="form-label">Pilih User <span class="text-danger">*</span></label>
                            <select class="form-select @error('id_user') is-invalid @enderror" id="id_user" name="id_user">
                                <option value="">-- Pilih User --</option>
                                @foreach($unassignedUsers as $user)
                                    <option value="{{ $user->iduser }}" {{ old('id_user') == $user->iduser ? 'selected' : '' }}>
                                        {{ $user->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_user')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div id="newUserSection" class="mb-3" style="display: {{ old('create_user') ? 'block' : 'none' }};">
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

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No HP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="bidang_dokter" class="form-label">Bidang Dokter <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('bidang_dokter') is-invalid @enderror" id="bidang_dokter" name="bidang_dokter" value="{{ old('bidang_dokter') }}" required>
                            @error('bidang_dokter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" name="jenis_kelamin" id="jenis_kelamin_l" value="L" {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="jenis_kelamin_l">
                                        Laki-laki
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" name="jenis_kelamin" id="jenis_kelamin_p" value="P" {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="jenis_kelamin_p">
                                        Perempuan
                                    </label>
                                </div>
                            </div>
                            @error('jenis_kelamin')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        function toggleUserSections() {
            const create = document.getElementById('create_user').checked;
            const existing = document.getElementById('existingUserSection');
            const newer = document.getElementById('newUserSection');
            if (existing && newer) {
                existing.style.display = create ? 'none' : 'block';
                newer.style.display = create ? 'block' : 'none';
            }
            const idSel = document.getElementById('id_user');
            if (idSel) idSel.required = !create;
            ['nama','email','password','password_confirmation'].forEach(id => {
                const el = document.getElementById(id);
                if (el) el.required = create;
            });
        }
        const chk = document.getElementById('create_user');
        if (chk) {
            chk.addEventListener('change', toggleUserSections);
            toggleUserSections();
        }
    });
</script>
@endpush

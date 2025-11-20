@extends('layouts.admin.main')

@section('title', 'Edit Perawat')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Data Perawat</h3>
                </div>
                <form action="{{ route('admin.perawat.update', $perawat->id_perawat) }}" method="POST">
                    @csrf
                    @method('PUT')
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
                            <label for="id_user" class="form-label">Pilih User <span class="text-danger">*</span></label>
                            <select class="form-select @error('id_user') is-invalid @enderror" id="id_user" name="id_user" required>
                                <option value="">-- Pilih User --</option>
                                @foreach($unassignedUsers as $user)
                                    <option value="{{ $user->iduser }}" {{ old('id_user', $perawat->id_user) == $user->iduser ? 'selected' : '' }}>
                                        {{ $user->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_user')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $perawat->alamat) }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="no_hp" class="form-label">No HP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp', $perawat->no_hp) }}" required>
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="pendidikan" class="form-label">Pendidikan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('pendidikan') is-invalid @enderror" id="pendidikan" name="pendidikan" value="{{ old('pendidikan', $perawat->pendidikan) }}" required>
                            @error('pendidikan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" name="jenis_kelamin" id="jenis_kelamin_l" value="L" {{ old('jenis_kelamin', $perawat->jenis_kelamin) == 'L' ? 'checked' : '' }} required>
                                    <label class="form-check-label" for="jenis_kelamin_l">
                                        Laki-laki
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" type="radio" name="jenis_kelamin" id="jenis_kelamin_p" value="P" {{ old('jenis_kelamin', $perawat->jenis_kelamin) == 'P' ? 'checked' : '' }} required>
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
                            <i class="fas fa-save"></i> Update
                        </button>
                        <a href="{{ route('admin.perawat.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

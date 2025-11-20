@extends('layouts.resepsionis.main')

@section('title', 'Edit Pet')

@section('content')
<!-- Content Header -->
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Edit Pet</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('resepsionis.pet.index') }}">Pet</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- Main content -->
<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Form Edit Pet</h3>
                    </div>
                    <form action="{{ route('resepsionis.pet.update', $pet->idpet) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Pet <span class="text-danger">*</span></label>
                                <input type="text" name="nama" id="nama" value="{{ old('nama', $pet->nama) }}" class="form-control @error('nama') is-invalid @enderror" required>
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                    <option value="M" {{ old('jenis_kelamin', $pet->jenis_kelamin) == 'M' ? 'selected' : '' }}>Jantan</option>
                                    <option value="F" {{ old('jenis_kelamin', $pet->jenis_kelamin) == 'F' ? 'selected' : '' }}>Betina</option>
                                </select>
                                @error('jenis_kelamin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tanggal_lahir" class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', $pet->tanggal_lahir?->format('Y-m-d')) }}" class="form-control @error('tanggal_lahir') is-invalid @enderror" required>
                                @error('tanggal_lahir')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="warna_tanda" class="form-label">Warna/Tanda <span class="text-danger">*</span></label>
                                <textarea name="warna_tanda" id="warna_tanda" rows="2" class="form-control @error('warna_tanda') is-invalid @enderror" required placeholder="Contoh: Putih dengan bintik hitam di dahi">{{ old('warna_tanda', $pet->warna_tanda) }}</textarea>
                                @error('warna_tanda')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="id_pemilik" class="form-label">Pemilik <span class="text-danger">*</span></label>
                                <select name="id_pemilik" id="id_pemilik" class="form-select @error('id_pemilik') is-invalid @enderror" required>
                                    <option value="">-- Pilih Pemilik --</option>
                                    @foreach($pemilik as $p)
                                        <option value="{{ $p->idpemilik }}" {{ old('id_pemilik', $pet->id_pemilik) == $p->idpemilik ? 'selected' : '' }}>
                                            {{ $p->user->nama ?? 'N/A' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_pemilik')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="id_ras_hewan" class="form-label">Ras Hewan <span class="text-danger">*</span></label>
                                <select name="id_ras_hewan" id="id_ras_hewan" class="form-select @error('id_ras_hewan') is-invalid @enderror" required>
                                    <option value="">-- Pilih Ras Hewan --</option>
                                    @foreach($rasHewan as $ras)
                                        <option value="{{ $ras->idras_hewan }}" {{ old('id_ras_hewan', $pet->id_ras_hewan) == $ras->idras_hewan ? 'selected' : '' }}>
                                            {{ $ras->nama_ras }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('id_ras_hewan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save"></i> Update
                            </button>
                            <a href="{{ route('resepsionis.pet.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

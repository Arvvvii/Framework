@extends('layouts.dokter.main')

@section('title', 'Tambah Detail Tindakan/Terapi')

@section('content')
<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">Tambah Detail Tindakan/Terapi</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                    <li class="breadcrumb-item"><a href="{{ route('dokter.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dokter.pasien.index') }}">Data Pasien</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dokter.rekammedis.index', ['pet' => $petId]) }}">Rekam Medis</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('dokter.rekammedis.detail.index', [$rekamMedis->idrekam_medis, 'pet' => $petId]) }}">Detail</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="app-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('dokter.rekammedis.detail.store', [$rekamMedis->idrekam_medis, 'pet' => $petId]) }}" method="POST">
                    @csrf
                    <div id="itemsContainer">
                        <div class="item border rounded p-3 mb-3">
                            <div class="mb-3">
                                <label class="form-label">Kode Tindakan/Terapi</label>
                                <select name="items[0][idkode_tindakan_terapi]" class="form-control" required>
                                    <option value="">-- Pilih Kode Tindakan/Terapi --</option>
                                    @foreach($kodeTindakan as $kode)
                                        <option value="{{ $kode->idkode_tindakan_terapi }}">{{ $kode->kode }} - {{ $kode->deskripsi_tindakan_terapi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Detail</label>
                                <textarea name="items[0][detail]" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeItem(this)">Hapus Tindakan</button>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-outline-primary" id="addItemBtn">+ Tambah Tindakan</button>
                        <div class="text-end">
                        <a href="{{ route('dokter.rekammedis.detail.index', [$rekamMedis->idrekam_medis, 'pet' => $petId]) }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function(){
        const container = document.getElementById('itemsContainer');
        const addBtn = document.getElementById('addItemBtn');
        let idx = 1;
        addBtn.addEventListener('click', () => {
            const tmpl = document.createElement('div');
            tmpl.className = 'item border rounded p-3 mb-3';
            tmpl.innerHTML = `
                <div class="mb-3">
                    <label class="form-label">Kode Tindakan/Terapi</label>
                    <select name="items[${idx}][idkode_tindakan_terapi]" class="form-control" required>
                        <option value="">-- Pilih Kode Tindakan/Terapi --</option>
                        @foreach($kodeTindakan as $kode)
                            <option value="{{ $kode->idkode_tindakan_terapi }}">{{ $kode->kode }} - {{ $kode->deskripsi_tindakan_terapi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Detail</label>
                    <textarea name="items[${idx}][detail]" class="form-control" rows="3" required></textarea>
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeItem(this)">Hapus Tindakan</button>
                </div>`;
            container.appendChild(tmpl);
            idx++;
        });
    })();
    function removeItem(btn){
        const block = btn.closest('.item');
        if(block) block.remove();
    }
</script>
@endpush

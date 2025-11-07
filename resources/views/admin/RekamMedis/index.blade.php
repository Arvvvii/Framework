@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Rekam Medis Management</h1>

    <div class="mb-3">
        <a href="{{ route('admin.rekammedis.create') }}" class="btn btn-primary">Tambah Rekam Medis</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID Rekam Medis</th>
                <th>Tanggal Dibuat</th>
                <th>Anamnesa</th>
                <th>Temuan Klinis</th>
                <th>Diagnosa</th>
                <th>Dokter Pemeriksa</th>
                <th>Nama Pet</th>
                <th>Pemilik Pet</th>
                <th>Ras Hewan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekamMedis as $rekam)
                <tr>
                    <td>{{ $rekam->idrekam_medis }}</td>
                    <td>
                        {{ $rekam->created_at?->format('d-m-Y H:i:s') ?? 'N/A' }}<br>
                        <small>{{ $rekam->created_at?->diffForHumans() }}</small>
                    </td>
                    <td>{{ $rekam->anamnesa }}</td>
                    <td>{{ $rekam->temuan_klinis }}</td>
                    <td>{{ $rekam->diagnosa }}</td>
                    <td>{{ $rekam->roleUser->user->nama ?? 'N/A' }}</td>
                    <td>{{ $rekam->temuDokter->pet->nama ?? 'N/A' }}</td>
                    <td>{{ optional($rekam->temuDokter->pet->pemilik->user)->nama ?? 'N/A' }}</td>
                    <td>{{ optional($rekam->temuDokter->pet->rasHewan)->nama_ras ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('admin.rekammedis.edit', $rekam) }}" class="btn btn-sm btn-secondary">Edit</a>

                        <form action="{{ route('admin.rekammedis.destroy', $rekam) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus rekam medis ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9">No rekam medis found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
